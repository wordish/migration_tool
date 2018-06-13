<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Processor;

use Concrete\Core\Foundation\Processor\TargetInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\Queue\QueueFactory;
use PortlandLabs\Concrete5\MigrationTool\Batch\Processor\Task\MapContentTypesTask;

defined('C5_EXECUTE') or die("Access Denied.");

class TargetItemProcessor
{
    protected $section;

    public function __construct(TargetInterface $target)
    {
        $batch = $target->getBatch();
        $factory = new QueueFactory();
        $this->setQueue($factory->getMapperQueue($batch)->getQueue());
        $this->registerTask(new MapContentTypesTask());
    }

}
