<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\ClearBatchCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateContentEditorSnippetsCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateGroupsCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateWorkflowTypesCommand;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateContentEditorSnippetsRoutine extends AbstractRoutine
{

    public function getCommandClass()
    {
        return CreateContentEditorSnippetsCommand::class;
    }

}
