<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Arrets;
use App\Entity\Partie;
use App\Entity\Dossier;
use App\Entity\Audience;
use App\Form\ArretsType;
use App\Form\DossierType;
use App\Form\AudienceType;
use Infobip\Configuration;
use Infobip\Api\SendSmsApi;
use App\Entity\AffecterUser;
use App\Service\MailService;
use App\Form\UserDossierType;
use App\Service\FileUploader;
use App\Form\AffecterUserType;
use App\Form\DossierModifType;
use App\Service\CodeGenerator;
use App\Entity\AffecterSection;
use App\Entity\AffecterStructure;
use App\Form\AffecterSectionType;
use Infobip\Model\SmsDestination;
use Symfony\Component\Mime\Email;
use App\Form\DossierDefendeurType;
use App\Form\DossierRequerantType;
use App\Form\OuvertureDossierType;
use App\Form\AffecterStructureType;
use App\Form\AjoutPieceDossierType;
use Symfony\Component\Mime\Address;
use App\Repository\ArretsRepository;
use App\Repository\PartieRepository;
use Infobip\Model\SmsTextualMessage;
use App\Repository\DossierRepository;
use App\Repository\AudienceRepository;
use App\Repository\DefendeurRepository;
use App\Repository\UserDossierRepository;
use App\Repository\AffecterUserRepository;
use App\Repository\RepresentantRepository;
use App\Repository\ArrondissementRepository;
use Infobip\Model\SmsAdvancedTextualRequest;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use App\Repository\AffecterSectionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\AffecterStructureRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MesuresInstructionsRepository;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

//#[Route(path: '/dossier')]
#[Route(path: '/recours')]
//#[IsGranted()]
class DossierController extends AbstractController
{

    #[Route(path: '/liste-des-recours', name: 'app_dossier_index')]
    public function index(#[CurrentUser] User    $user, DossierRepository $dossierRepository): Response
    {
        return $this->render('dossier/index.html.twig', [
            'dossiers' => $dossierRepository->findBy([
                'etatDossier' => 'RECOURS',
                //                'createdBy'=>$this->getUser(),
                //                'structure'=>$this->getUser()->getStructure()
            ]),
        ]);
    }


    #[Route(path: '/new', name: 'app_dossier_new')]
    public function new(
        #[CurrentUser] User    $user,
        Request $request,
        DossierRepository $dossierRepository,
        ArrondissementRepository $arrondissementRepository,
        DefendeurRepository $defendeurRepository,
        PartieRepository      $requerantRepository
    ): Response {
        $dossier = new Dossier();
        $form = $this->createForm(DossierType::class, $dossier);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            //            dd($request->request->get("city"));
            // dd($arrondissementRepository->find($request->request->get("localite_requerent")),$arrondissementRepository->find($request->request->get("localite_defendeur")));
            // Recuperation des id de la locallite du requerent et du defendeur
            //            $localite_requerant_id= $request->request->get("localite_requerent");
            //            $localite_defendeur_id=$request->request->get("localite_defendeur");
            //            $localite_requerant= $arrondissementRepository->find( $localite_requerant_id);
            //            $localite_defendeur=  $arrondissementRepository->find($localite_defendeur_id);
            //            $dossier->getRequerant()->setLocalite( $localite_requerant);
            //            $dossier->getDefendeur()->setLocalite( $localite_defendeur);

            $requerant_telephone = $form->get('requerant')->get('Telephone')->getData();
            $defendeur_telephone = $form->get('defendeur')->get('telephone')->getData();
            //            $defendeur_telephone = $form->get('defendeur')->get('telephone')->getData();
            $requerant_exist = $requerantRepository->findOneBy(['Telephone' => $requerant_telephone]);
            $defendeur_exist = $defendeurRepository->findOneBy(['telephone' => $defendeur_telephone]);

            //            if ($requerant_exist) {
            //                $dossier->setRequerant($requerant_exist);
            //            } else {
            //                $localite_requerant_id = $request->request->get("localite_requerent");
            //                $localite_requerant = $arrondissementRepository->find($localite_requerant_id);
            //                $dossier->getRequerant()->setLocalite($localite_requerant);
            //            }
            //
            //
            //            if ($defendeur_exist) {
            //                $dossier->setDefendeur($defendeur_exist);
            //            } else {
            //                $localite_defendeur_id = $request->request->get("localite_defendeur");
            //                $localite_defendeur = $arrondissementRepository->find($localite_defendeur_id);
            //                $dossier->getDefendeur()->setLocalite($localite_defendeur);
            //
            //            }


            //            dd($requerant_telephone,$defendeur_telephone);


            foreach ($dossier->getPieces() as $piece) {
                $piece->setDossier($dossier);
            }
            // $dossier->setCreatedBy($this->getUser());
            $dossierRepository->add($dossier, true);
            $this->addFlash('success', 'La réquete a été enregistrée avec success');
            return $this->redirectToRoute('app_dossier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('dossier/new.html.twig', [
            'dossier' => $dossier,
            'form' => $form,
        ]);
    }

    #[Route(path: '/new/requerant', name: 'app_dossier_new_requerant')]
    //    #[IsGranted('ROLE_GREFFIER_EN_CHEF','ROLE_BUREAU_ORIENTATION')]
    #[IsGranted(new Expression('is_granted("ROLE_GREFFIER") or is_granted("ROLE_GREFFIER_EN_CHEF") or is_granted("ROLE_BUREAU_ORIENTATION")'))]
    public function etapeRequerant(
        SessionInterface $session,
        Request $request,
        DossierRepository $dossierRepository,
        ArrondissementRepository $arrondissementRepository,
        RepresentantRepository $representantRepository,
        PartieRepository                          $requerantRepository
    ) {

        $dossier = new Dossier();

        $form = $this->createForm(DossierRequerantType::class, $dossier, ['action' => $this->generateUrl('app_dossier_new_requerant')]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //  $requerant_telephone = $form->get('requerant')->get('Telephone')->getData();
            //  $requerant_exist = $requerantRepository->findOneBy(['Telephone' => $requerant_telephone, 'status' => 'REQUERANT']);

            // if ($requerant_exist) {
            //   $dossier->setRequerant($requerant_exist);
            // } else {
            $localite_requerant_id = $request->request->get("localite_requerent");
            $localite_requerant = $arrondissementRepository->find($localite_requerant_id);
            $dossier->getRequerant()->setLocalite($localite_requerant);
            // }

            //            $this->addFlash('success', 'La réquete a été enregistrée avec success');
            $dossier->getRequerant()->setStatus('REQUERANT');

            $type = $form->get('requerant')->get('type')->getData();
            if ($type == 'moral') {
                if ($form->get('requerant')->get('representants1')) {

                    $data_represantant = $form->get('requerant')->get('representants1')->getData();

                    //                dd( $data_represantant['nom']);
                    if ($data_represantant) {
                        $data_represantant->setPartie($dossier->getRequerant());
                        $representantRepository->add($data_represantant, true);
                    }
                }
            }
            $dossierRepository->add($dossier, true);
            $session->set('_dossier', $dossier->getId());
            return $this->redirectToRoute('app_dossier_new_defendeur', [], Response::HTTP_SEE_OTHER);
        }

        // Handle AJAX request
        if ($request->isXmlHttpRequest()) {
            return $this->render('meetup/_subform.html.twig', [
                'form' => $form->createView(),
            ]);
        }
        return $this->render('dossier/new_dossier_requerant.html.twig', [
            'dossier' => $dossier,
            'form' => $form,
        ]);
    }

    #[Route(path: '/new/defendeur', name: 'app_dossier_new_defendeur')]
    #[IsGranted(new Expression('is_granted("ROLE_GREFFIER") or is_granted("ROLE_GREFFIER_EN_CHEF") or is_granted("ROLE_BUREAU_ORIENTATION")'))]
    public function etapeDefendeur(
        SessionInterface $session,
        Request $request,
        DossierRepository $dossierRepository,
        ArrondissementRepository $arrondissementRepository,
        RepresentantRepository $representantRepository,
        PartieRepository                          $requerantRepository
    ) {
        $dossier_id = $session->get('_dossier');
        if ($dossier_id) {
            $dossier = $dossierRepository->find($dossier_id);

            $form = $this->createForm(DossierDefendeurType::class, $dossier, ['action' => $this->generateUrl('app_dossier_new_defendeur')]);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $defendeur_telephone = $form->get('defendeur')->get('telephone')->getData();
                $defendeur_exist = $requerantRepository->findOneBy(['Telephone' => $defendeur_telephone, 'status' => 'DEFENDEUR']);

                if ($defendeur_exist) {
                    $dossier->setDefendeur($defendeur_exist);
                } else {
                    $localite_defendeur_id = $request->request->get("localite_defendeur");
                    //                    dd($localite_defendeur_id);
                    $localite_defendeur = $arrondissementRepository->find($localite_defendeur_id);
                    $dossier->getDefendeur()->setLocalite($localite_defendeur);
                }
                $dossier->getDefendeur()->setStatus('DEFENDEUR');

                $type = $form->get('defendeur')->get('type')->getData();
                if ($type == 'moral') {
                    if ($form->get('defendeur')->get('representants1')) {
                        $data_represantant = $form->get('defendeur')->get('representants1')->getData();
                        //                dd( $data_represantant['nom']);
                        if ($data_represantant) {
                            $data_represantant->setPartie($dossier->getRequerant());
                            $representantRepository->add($data_represantant, true);
                        }
                    }
                }
                $dossierRepository->add($dossier, true);
                //  $session->set('_dossier', $dossier->getId());
                return $this->redirectToRoute('app_dossier_new_dossier', [], Response::HTTP_SEE_OTHER);
            }

            if ($request->isXmlHttpRequest()) {
                return $this->render('meetup/_subform.html.twig', [
                    'form' => $form->createView(),
                ]);
            }
        } else {
            return $this->redirectToRoute('app_dossier_new_requerant');
        }
        return $this->render('dossier/new_dossier_defendeur.html.twig', [
            'dossier' => $dossier,
            'form' => $form,
        ]);
    }

    #[Route(path: '/new/dossier', name: 'app_dossier_new_dossier')]
    #[IsGranted(new Expression('is_granted("ROLE_GREFFIER") or is_granted("ROLE_GREFFIER_EN_CHEF") or is_granted("ROLE_BUREAU_ORIENTATION")'))]
    public function etapeDossier(
        SessionInterface $session,
        Request $request,
        DossierRepository $dossierRepository,
        FileUploader $fileUploader,
        CodeGenerator $codeGenerator,
        MailService $mailService
    ) {
        $dossier_id = $session->get('_dossier');
        if ($dossier_id) {
            $dossier = $dossierRepository->find($dossier_id);
            $form = $this->createForm(DossierType::class, $dossier);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                //                dd($form->get('pieces')->all());
                foreach ($form->get('pieces')->all() as $pieceitem) {
                    $piece = $pieceitem->getData();
                    $image = $pieceitem->get('document')->getData();
                    $fmane = $form->get('referenceEnregistrement')->getData();
                    $fichier = $fileUploader->upload($image, $fmane, 'piecesJointes');
                    $piece->setUrl($fichier);
                    $piece->setDossier($dossier);
                }
                do {
                    // Générer un code aléatoire
                    $codeSuivi = $codeGenerator->Generator();

                    // Vérifier si le code existe déjà dans la base de données
                    $existingCode = $dossierRepository->findOneBy(['codeSuivi' => $codeSuivi]);
                } while ($existingCode !== null);
                $dossier->setCodeSuivi($codeSuivi);

                if ($dossier->getRequerant()->getEmail()) {
                    $mail = $dossier->getRequerant()->getEmail();
                    $sujet = 'Votre recours a été bien enregistré';

                    $context = [
                        'requerent' => $dossier->getRequerant()->getPrenoms() . ' ' . $dossier->getRequerant()->getNom(),
                        'codeSuivi' => $codeSuivi,
                        'lien' => $this->generateUrl('front_recours_status', [], UrlGeneratorInterface::ABSOLUTE_URL),

                    ];

                    $mailService->sendEmail($mail, $sujet, 'resume.html.twig', $context);


                    $sujet = 'Votre recours a été bien enregistré';

                    $context = [
                        'requerent' => $dossier->getRequerant()->getPrenoms() . ' ' . $dossier->getRequerant()->getNom(),
                        'codeSuivi' => $codeSuivi,
                        'lien' => $this->generateUrl('front_recours_status', [], UrlGeneratorInterface::ABSOLUTE_URL),

                    ];

                    $mailService->sendEmail($mail, $sujet, 'resume.html.twig', $context);
                }

                $dossier->setCreatedBy($this->getUser());
                $dossier->setEtatDossier('RECOURS');
                $dossierRepository->add($dossier, true);
                $this->addFlash('success', 'La réquete a été enregistrée avec success');
                return $this->redirectToRoute('app_dossier_index', [], Response::HTTP_SEE_OTHER);
            }
        } else {
            return $this->redirectToRoute('app_dossier_new_defendeur');
        }
        return $this->render('dossier/new_dossier.html.twig', [
            'dossier' => $dossier,
            'form' => $form,
        ]);
    }

    #[Route(path: 'new/resume', name: 'app_dossier_new_resume')]
    public function recaputilatif(SessionInterface $session, Request $request, DossierRepository $dossierRepository)
    {
        $dossier_id = $session->get('_dossier');
        if ($dossier_id) {

            $dossier = $dossierRepository->find($dossier_id);
            $session->remove('_dossier');
        } else {
            return $this->redirectToRoute('app_index_front');
        }
        //        dd( $dossier );
        return $this->render('front/recours/resume.html.twig', [
            'dossier' => $dossier,
            //            'form' => $form,
        ]);
    }


    //    #[Route('/{id}', name: 'app_dossier_show', methods: ['GET'])]
    //    public function show(Dossier $dossier): Response
    //    {
    //        return $this->render('dossier/show.html.twig', [
    //            'dossier' => $dossier,
    //        ]);
    //    }
    #[Route(path: '/ouverture-dossier/{id}', name: 'app_dossier_open')]
    #[IsGranted(new Expression('is_granted("ROLE_GREFFIER") or is_granted("ROLE_GREFFIER_EN_CHEF")'))]
    public function ouvertureDossier(Request $request, Dossier $dossier, DossierRepository $dossierRepository): Response

    {

        $form = $this->createForm(OuvertureDossierType::class, $dossier);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $dossier->setEtatDossier('OUVERT');
            $dossier->setDateOuverture(new \DateTime());
            $dossierRepository->add($dossier, true);
            $this->addFlash('success', 'Le dossier à été ouvert avec succes');
            return $this->redirectToRoute('app_dossier_open_list');
        }

        return $this->render('dossier/ouverture_dossier.html.twig', [
            'dossier' => $dossier,
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/liste-dossier-ouvert/', name: 'app_dossier_open_list')]
    public function ListeDossierOuvert(#[CurrentUser] User    $user, DossierRepository $dossierRepository): \Symfony\Component\HttpFoundation\Response
    {

        return $this->render('dossier/index_ouverture.html.twig', [
            'dossiers' => $dossierRepository->listeDossierOuvert(),
        ]);
    }

    #[Route(path: '/affectations/', name: 'app_dossier_affectations_list')]
    public function ListeAffectations(#[CurrentUser] User    $user, DossierRepository $dossierRepository): \Symfony\Component\HttpFoundation\Response
    {

        return $this->render('dossier/index_affectation.html.twig', [
            'dossiers' => $dossierRepository->findBy(['etatDossier' => 'OUVERT']),
        ]);
    }


    #[Route(path: '/affectation/dossier/structure/{id}', name: 'admin_affecter_dossier_structure_new', methods: ['GET', 'POST'])]
    public function affectionStructureDossier(#[CurrentUser] User    $user, Request $request, AffecterStructureRepository $affecterStructureRepository, Dossier $dossier): Response
    {
        $affecterStructure = new AffecterStructure();
        $affecterStructure->setDossier($dossier);
        $form = $this->createForm(AffecterStructureType::class, $affecterStructure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $affecterStructure->setDe($this->getUser()->getStructure());
            $affecterStructureRepository->add($affecterStructure, true);
            $this->addFlash('success', 'le dossier a été bien affecté à la structure : ' . $form->get('structure')->getData()->getName());

            return $this->redirectToRoute('admin_dossier_affections', ['id' => $dossier->getId()]);
        }

        return $this->render('affecter_structure/new.html.twig', [
            //            'affecter_structure' => $affecterStructure,
            'dossier' => $dossier,
            'form' => $form,
        ]);
    }

    #[Route(path: '/transfert-dossier/{id}', name: 'admin_transfert_dossier_user', methods: ['GET', 'POST'])]
    public function affectionUser(#[CurrentUser] User    $user, Request $request, AffecterUserRepository $affecterUserRepository, Dossier $dossier): Response
    {
        $affecterStructure = new AffecterUser();
        $affecterStructure->setDossier($dossier);
        $form = $this->createForm(AffecterUserType::class, $affecterStructure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $affecterStructure->setExpediteur($user);
            $affecterUserRepository->add($affecterStructure, true);
            $this->addFlash('success', 'le dossier a été bien transferé au greffier : ' . $form->get('destinataire')->getData()->getUserInformations() . ' pour ouverture');
            return $this->redirectToRoute('admin_dossier_affections', ['id' => $dossier->getId()]);
        }

        return $this->render('affecter_structure/new.html.twig', [
            //            'affecter_structure' => $affecterStructure,
            'dossier' => $dossier,
            'form' => $form,
        ]);
    }

    #[Route(path: '/affectation/dossier/section/{id}', name: 'admin_affectr_dossier_section_new', methods: ['GET', 'POST'])]
    public function affectionSectionDossier(#[CurrentUser] User    $user, Request $request, AffecterSectionRepository $affecterSectionRepository, Dossier $dossier): Response
    {
        $affecterSection = new AffecterSection();
        $affecterSection->setDossier($dossier);
        $form = $this->createForm(AffecterSectionType::class, $affecterSection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $affecterSectionRepository->add($affecterSection, true);
            $this->addFlash('success', 'le dossier a été bien affecté à la structure : ' . $form->get('section')->getData()->getName());


            return $this->redirectToRoute('admin_affectation_all');
        }

        return $this->render('affecter_section/new.html.twig', [
            'affecter_section' => $affecterSection,
            'form' => $form,
            'dossier' => $dossier,
        ]);
    }

    #[Route(path: '/details-dossier/{id}', name: 'admin_dossier_details')]
    public function detailsDossier(#[CurrentUser] User    $user, Request $request, Dossier $dossier, MesuresInstructionsRepository $mesure): Response
    {

        $generate_rapport = false;
        $dossier1 = new Dossier();

        $form = $this->createForm(AjoutPieceDossierType::class, $dossier1);
        $form->handleRequest($request);
        $lastMesure = $mesure->findOneBy(['dossier' => $dossier], ['createdAt' => 'DESC']);
        if ($lastMesure) {
            if ($lastMesure->getEtat() == 'ECHOUE' && ($lastMesure->getInstruction()->getLibelle() == 'Paiement de consignation' || $lastMesure->getInstruction()->getLibelle() == 'Mise en demeure pour production de mémoire ampliantif') || $lastMesure->getInstruction()->getLibelle() == 'Production de mémoire ampliatif' || $lastMesure->getInstruction()->getLibelle() == 'Production de mémoire ampliatif') {
                $generate_rapport = true;
            } else {
                $generate_rapport = false;
            }
        } else {
            $generate_rapport = false;
        }


        return $this->render('dossier/details_dossier.html.twig', [
            'dossier' => $dossier,
            'generate_rapport' => $generate_rapport,
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/affectation-dossier/{id}', name: 'admin_dossier_affections')]
    public function detailsDossierAffectation(#[CurrentUser] User    $user, Dossier $dossier): \Symfony\Component\HttpFoundation\Response
    {
        return $this->render('dossier/details_affectation_dossier.html.twig', [
            'dossier' => $dossier,

        ]);
    }

    #[Route(path: '/affectation-dossier-user/{id}', name: 'admin_dossier_affections_user')]
    public function DossierAffectationUser(Request $request, Dossier $dossier, UserDossierRepository $dossierRepository, MailerInterface $mailer)
    {

        $form = $this->createForm(UserDossierType::class, $dossier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($dossier->getUserDossiers() as $userDossier) {
                $userDossier->setDossier($dossier);
                $membre = $userDossier->getUser();
                $dossierRepository->add($userDossier, true);

                if ($membre->getEmail()) {
                    $email = (new TemplatedEmail())
                        ->from('xxxxx@fuprobenin.org')
                        ->to(new Address($membre->getEmail()))
                        // ->priority(Email::PRIORITY_HIGH)
                        ->subject('Ajout en tant membre au dossier : ' . $dossier->getReferenceDossier())
                        ->priority(Email::PRIORITY_HIGH)

                        // path of the Twig template to render
                        ->htmlTemplate('mailer/ajout_membre.html.twig')

                        // pass variables (name => value) to the template
                        ->context([
                            'dossier' => $dossier,
                            'user' => $userDossier,
                            'membre' => $membre
                        ]);

                    $mailer->send($email);
                }
            }
            $this->addFlash('success', 'Les membres ont été bien ajoutés au dossier');
            return $this->redirectToRoute('admin_dossier_details', ['id' => $dossier->getId()]);
        }
        return $this->render('dossier/affectation_user_dossier.html.twig', [
            'dossier' => $dossier,
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/affectation-membres/{id}', name: 'admin_dossier_affections_membres')]
    public function membreDossier(#[CurrentUser] User    $user, Dossier $dossier, UserDossierRepository $dossierRepository): \Symfony\Component\HttpFoundation\Response
    {

        $membres = $dossierRepository->findBy(['dossier' => $dossier]);
        return $this->render('dossier/affectation_membre_dossier.html.twig', [
            'dossier' => $dossier,
            'membres' => $membres
        ]);
    }

    #[Route(path: '/toutes-les-affectations', name: 'admin_affectation_all', methods: ['GET', 'POST'])]
    public function affectations(AffecterStructureRepository $affecterStructureRepository, AffecterSectionRepository $affecterSectionRepository): \Symfony\Component\HttpFoundation\Response
    {
        $affectations = $affecterStructureRepository->findBy([], ['id' => 'DESC']);
        $sections = $affecterSectionRepository->findBy([], ['id' => 'DESC']);
        return $this->render('dossier/toutes_les_affectations.html.twig', [
            'affectations' => $affectations,
            'sections' => $sections
        ]);
    }

    #[Route('/{id}', name: 'app_dossier_delete', methods: ['POST'])]
    public function delete(#[CurrentUser] User    $user, Request $request, Dossier $dossier, DossierRepository $dossierRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $dossier->getId(), $request->request->get('_token'))) {
            $dossierRepository->remove($dossier, true);
        }

        return $this->redirectToRoute('app_dossier_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route(path: '/programmer-une-audience', name: 'app_audience_new1', methods: ['GET', 'POST'])]
    public function audience(#[CurrentUser] User    $user, Request $request, AudienceRepository $audienceRepository, MailerInterface $mailer, DossierRepository $dossierRepository): Response
    {
        $audience = new Audience();
        $form = $this->createForm(AudienceType::class, $audience);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //            $audience->setDossier($dossier);
            // $audienceRepository->add($audience, true);
            //            $smsMessage = "L'audience du  dossier : " . $dossier->getReferenceDossier() . " a été programmé le : " . $audience->getDateAudience()->format("Y-m-d H:i:s");
            //            dd($smsMessage);
            foreach ($form->get('dossiers')->getData() as $dossier) {
                $dossier->setEtatDossier('AUDIENCE');
                $requerant_mail = $dossier->getRequerant()->getEmail();
                $request_telephone = $dossier->getRequerant()->getTelephone();
                $defendeur_mail = $dossier->getDefendeur()->getEmail();
                $defendeur_telephone = $dossier->getDefendeur()->getTelephone();
                $smsMessage = "L'audience du  dossier : " . $dossier->getIntituleObjet() . " a été programmé le : " . $audience->getDateAudience()->format("Y-m-d") . " à " . $audience->getHeureAudience()->format("H:i:s");
                if ($requerant_mail) {
                    $email = (new TemplatedEmail())
                        ->from('xxxxx@fuprobenin.org')
                        ->to(new Address($requerant_mail))
                        // ->priority(Email::PRIORITY_HIGH)
                        ->subject('Programmation de l\'audience du dossier : ' . $dossier->getReferenceDossier())
                        ->priority(Email::PRIORITY_HIGH)

                        // path of the Twig template to render
                        ->htmlTemplate('mailer/partie_audience.html.twig')

                        // pass variables (name => value) to the template
                        ->context([
                            'dossier' => $dossier,
                            'audience' => $audience,
                            'nom' => $dossier->getRequerant()->getNom()

                        ]);

                    $mailer->send($email);
                }

                if ($defendeur_mail) {
                    $email = (new TemplatedEmail())
                        ->from('xxxxx@fuprobenin.org')
                        ->to(new Address($defendeur_mail))
                        // ->priority(Email::PRIORITY_HIGH)
                        ->subject('Programmation de l\'audience du dossier : ' . $dossier->getReferenceDossier())
                        ->priority(Email::PRIORITY_HIGH)

                        // path of the Twig template to render
                        ->htmlTemplate('mailer/partie_audience.html.twig')

                        // pass variables (name => value) to the template
                        ->context([
                            'dossier' => $dossier,
                            'audience' => $audience,
                            'nom' => $dossier->getDefendeur()->getNom()

                        ]);

                    $mailer->send($email);
                }

                if ($request_telephone) {
                    $this->envoiSMS($smsMessage, $request_telephone);
                }
                if ($defendeur_telephone) {
                    $this->envoiSMS($smsMessage, $defendeur_telephone);
                }

                foreach ($dossier->getUserDossiers() as $membre) {
                    if ($membre->getUSer()->getEmail()) {
                        $email = (new TemplatedEmail())
                            ->from('xxxxx@fuprobenin.org')
                            ->to(new Address($membre->getUSer()->getEmail()))
                            // ->priority(Email::PRIORITY_HIGH)
                            ->subject('Programmation de l\'audience du dossier : ' . $dossier->getReferenceDossier())
                            ->priority(Email::PRIORITY_HIGH)

                            // path of the Twig template to render
                            ->htmlTemplate('mailer/partie_audience.html.twig')

                            // pass variables (name => value) to the template
                            ->context([
                                'dossier' => $dossier,
                                'audience' => $audience,
                                'nom' => $membre->getUSer()->getNom()

                            ]);

                        $mailer->send($email);
                    }
                }
                $dossier->addAudience($audience);
                $dossierRepository->add($dossier);
            }
            $audienceRepository->add($audience, true);
            $this->addFlash('success', 'L\'audience du dossier : ' . $dossier->getReferenceDossier() . ' a été programmé avec succes');
            return $this->redirectToRoute('app_audience_programme', ['id' => $audience->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('audience/new.html.twig', [
            'audience' => $audience,

            'form' => $form,
        ]);
    }

    #[Route(path: '/audience-programmes/{id}', name: 'app_audience_programmes', methods: ['GET', 'POST'])]
    public function audienceProgramme(#[CurrentUser] User    $user, Audience $audience): \Symfony\Component\HttpFoundation\Response
    {
        return $this->render('dossier/audience_programme.html.twig', [
            'audience' => $audience,
        ]);
    }

    #[Route(path: '/audiences/liste', name: 'app_audience_liste', methods: ['GET', 'POST'])]
    public function listeAudience(#[CurrentUser] User    $user, AudienceRepository $audienceRepository): \Symfony\Component\HttpFoundation\Response
    {
        $audiences = $audienceRepository->findBy([], ['id' => 'DESC']);

        return $this->render('audience/index_audience.html.twig', [
            'audiences' => $audiences,

        ]);
    }

    #[Route(path: '/arret/{id}', name: 'admin_arret_new', methods: ['GET', 'POST'])]
    public function arrets(
        #[CurrentUser] User    $user,
        Dossier      $dossier,
        Request $request,
        ArretsRepository $arretsRepository,
        FileUploader $fileUploader,
        MailerInterface $mailer,
        DossierRepository $dossierRepository
    ): Response {
        $arret = new Arrets();
        $form = $this->createForm(ArretsType::class, $arret);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $arret->setDossier($dossier);
            $file_arret = $form->get('arret_file')->getData();
            $forclusion_file = $form->get('forclusion_file')->getData();
            $forclusion = $fileUploader->upload($forclusion_file, $form->get('titrage')->getData());
            $fichier = $fileUploader->upload($file_arret, $form->get('titrage')->getData());

            //    $arret->setArret($fichier);
            $arret->setForclusion($forclusion);

            $forclusion_arret = $form->get('forclusion_file')->getData();
            //            $fichier2 = $fileUploader->upload($forclusion_arret, $form->get('numArret')->getData());
            //
            $arret->setArret($fichier);
            $dossier->setEtatDossier("ARRETS");
            $arretsRepository->add($arret, true);
            // $audienceRepository->add($audience, true);
            //     $smsMessage = "L'audience du  dossier : " . $dossier->getReferenceDossier() . " a été programmé le : " . $audience->getDateAudience()->format("Y-m-d H:i:s");
            //            dd($smsMessage);
            $requerant_mail = $dossier->getRequerant()->getEmail();
            $request_telephone = $dossier->getRequerant()->getTelephone();
            $defendeur_mail = $dossier->getDefendeur()->getEmail();
            $defendeur_telephone = $dossier->getDefendeur()->getTelephone();


            /*if ($requerant_mail) {
               $email = (new TemplatedEmail())
                   ->from('xxxxx@fuprobenin.org')
                   ->to(new Address($requerant_mail))
                   // ->priority(Email::PRIORITY_HIGH)
                   ->subject('Programmation de l\'audience du dossier : ' . $dossier->getReferenceDossier())
                   ->priority(Email::PRIORITY_HIGH)

                   // path of the Twig template to render
                   ->htmlTemplate('mailer/partie_audience.html.twig')

                   // pass variables (name => value) to the template
                   ->context([
                       'dossier' => $dossier,
                       'audience' => $audience,
                       'nom' => $dossier->getRequerant()->getNom()

                   ]);

               $mailer->send($email);
           }

           /* if ($defendeuail) {
                $email = (new TemplatedEmail())
                    ->from('xxxxx@fuprobenin.org')
                    ->to(new Address($defendeur_mail))
                    // ->priority(Email::PRIORITY_HIGH)
                    ->subject('Programmation de l\'audience du dossier : ' . $dossier->getReferenceDossier())
                    ->priority(Email::PRIORITY_HIGH)

                    // path of the Twig template to render
                    ->htmlTemplate('mailer/partie_audience.html.twig')

                    // pass variables (name => value) to the template
                    ->context([
                        'dossier' => $dossier,
                        'audience' => $audience,
                        'nom' => $dossier->getDefendeur()->getNom()

                    ]);

                $mailer->send($email);
            }

            foreach ($dossier->getUserDossiers() as $membre) {
                if ($membre->getUSer()->getEmail()) {
                    $email = (new TemplatedEmail())
                        ->from('xxxxx@fuprobenin.org')
                        ->to(new Address($membre->getUSer()->getEmail()))
                        // ->priority(Email::PRIORITY_HIGH)
                        ->subject('Programmation de l\'audience du dossier : ' . $dossier->getReferenceDossier())
                        ->priority(Email::PRIORITY_HIGH)

                        // path of the Twig template to render
                        ->htmlTemplate('mailer/partie_audience.html.twig')

                        // pass variables (name => value) to the template
                        ->context([
                            'dossier' => $dossier,
                            'audience' => $audience,
                            'nom' => $membre->getUSer()->getNom()

                        ]);

                    $mailer->send($email);
              }
            }


            /*         if ($request_telephone) {
                         $this->envoiSMS($smsMessage, $request_telephone);

                     }
                     if ($defendeur_telephone) {
                         $this->envoiSMS($smsMessage, $defendeur_telephone);

                     }*/
            $this->addFlash('success', 'L\'audience du dossier : ' . $dossier->getReferenceDossier() . ' a été programmé avec succes');
            return $this->redirectToRoute('admin_arret_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('arrets/new.html.twig', [
            'arret' => $arret,
            'dossier' => $dossier,
            'form' => $form,
        ]);
    }


    #[Route(path: '/arrets/liste', name: 'admin_arret_list', methods: ['GET', 'POST'])]
    public function listeArret(#[CurrentUser] User    $user, ArretsRepository $arretsRepository): \Symfony\Component\HttpFoundation\Response
    {
        return $this->render('dossier/list_arrets.html.twig', [
            'arrets' => $arretsRepository->findBy([], ['id' => 'DESC']),
        ]);
    }


    #[Route(path: '/arrets/new', name: 'admin_arret_list_new', methods: ['GET', 'POST'])]
    public function nouvelArrets(#[CurrentUser] User    $user, DossierRepository $dossierRepository): \Symfony\Component\HttpFoundation\Response
    {
        return $this->render('dossier/index_arrets.html.twig', [
            'dossiers' => $dossierRepository->findBy([
                'etatDossier' => "AUDIENCE",
                //                'createdBy'=>$this->getUser(),
                //                'structure'=>$this->getUser()->getStructure()
            ]),
        ]);
    }


    public function envoiSMS($msg, $telephone)
    {
        // 1. Create configuration object and client
        $baseurl = $this->getParameter("sms_gateway.baseurl");
        $apikey = $this->getParameter("sms_gateway.apikey");
        $apikeyPrefix = $this->getParameter("sms_gateway.apikeyprefix");

        $configuration = (new Configuration())
            ->setHost($baseurl)
            ->setApiKeyPrefix('Authorization', $apikeyPrefix)
            ->setApiKey('Authorization', $apikey);

        $client = new \GuzzleHttp\Client();
        $sendSmsApi = new SendSMSApi($client, $configuration);

        // 2. Create message object with destination
        $destination = (new SmsDestination())->setTo($telephone);
        $message = (new SmsTextualMessage())
            // Alphanumeric sender ID length should be between 3 and 11 characters (Example: `CompanyName`).
            // Numeric sender ID length should be between 3 and 14 characters.
            ->setFrom('InfoSMS')
            ->setText($msg)
            ->setDestinations([$destination]);

        // 3. Create message request with all the messages that you want to send
        $request = (new SmsAdvancedTextualRequest())->setMessages([$message]);

        // 4. Send !
        try {
            $smsResponse = $sendSmsApi->sendSmsMessage($request);

            dump($smsResponse);
        } catch (\Throwable $apiException) {
            // HANDLE THE EXCEPTION
            dump($apiException);
        }
    }

    #[Route('/{id}/edit', name: 'app_dossier_edit', methods: ['GET', 'POST'])]

    public function edit(#[CurrentUser] User    $user, Request $request, Dossier $dossier, DossierRepository $dossierRepository): Response
    {
        $form = $this->createForm(DossierModifType::class, $dossier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dossierRepository->add($dossier, true);

            return $this->redirectToRoute('app_dossier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('dossier/edit.html.twig', [
            'dossier' => $dossier,
            'form' => $form,
            'requerant' => $dossier->getRequerant(),
            'defendeur' => $dossier->getDefendeur(),
        ]);
    }

    #[Route('/{id}', name: 'app_dossier_show', methods: ['GET'])]
    public function show(#[CurrentUser] User    $user, Dossier $dossier): Response
    {
        return $this->render('dossier/show.html.twig', [
            'dossier' => $dossier,
        ]);
    }
}
