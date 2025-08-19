<?php


namespace App\Utility;


use App\Entity\Log;
use Doctrine\ORM\EntityManagerInterface;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

class DbHandler extends AbstractProcessingHandler
{
    private  $manager;
    public function __construct(EntityManagerInterface $manager)
    {
        parent::__construct();
        $this->manager=$manager;
    }
//
//    protected function  write(array|\Monolog\LogRecord $record): void
//    {
//        //envoie de log dans la base de données
//        $log= new  Log();
//        $log->setContext($record['context']);
//        $log->setLevel($record['level']);
//        $log->setLevelName($record['level_name']);
//        $log->setMessage($record['message']);
//        $log->setExtra($record['extra']);
//       // $log->setUser($record['extra']['user']);
//        $this->manager->persist($log);
//        $this->manager->flush();
//
//
//    }

    protected function write(\Monolog\LogRecord $record): void
    {
        $log = new Log();
        $log->setContext($record->context);
        $log->setLevel($record->level->value);  // Utilise $record->level->value pour obtenir le niveau numérique
        $log->setLevelName($record->level->name); // Nom du niveau de log, comme 'ERROR'
        $log->setMessage($record->message);
        $log->setExtra($record->extra);

        $this->manager->persist($log);
        $this->manager->flush();
    }


}
