<?php 
    
namespace App\Classes;

// Laravel Classes
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Yaml\Yaml;
use File;

// Custom Classes
use App\Classes\ToastClass;


/*
    - Env
        - Git Username
        - Git Password
        - Git RepoName
        - Git BrancName(s) [ development, staging, preview, production ]

    - Process
        - Check repo exists, else create new repo
        - Checkout repo
        - Commit latet to repo
        - Push latest to remote origin branch
        - Report last -or- Throw error, void, rollback , and report issue 
*/

class GithubClass
{
    
    public $schema = [];
    public $repo = '';
    public $repoBranch = '';
    public $repoPath = '';

    public function __construct( $_schema , $_repoPath )
    {
        
        $this->toastClass = new ToastClass(array(
            'toastMessage' => 'Build Schema Initialized : [toastMessage]',
            'toastDuration' => 5000,
        ));

        $this->schema = $_schema;
        $this->repo =  $this->schema['websiteBuild']['target'];
        $this->repoBranch = $this->schema['websiteBuild']['domain']['slug'] . '-' . $this->repo;
        $this->repoPath = $_repoPath;
    }

    public function repoExec( $_command, $workdir = null ) 
    {
        if (is_null($workdir)) {
            $workdir = __DIR__;
        }
    
        $descriptorspec = array(
           0 => array("pipe", "r"),  // stdin
           1 => array("pipe", "w"),  // stdout
           2 => array("pipe", "w"),  // stderr
        );
        
        $process = proc_open(
            $_command,
            $descriptorspec,
            $pipes,
            $workdir,
            null
        );
    
        $stdout = stream_get_contents($pipes[1]);
        fclose($pipes[1]);
    
        $stderr = stream_get_contents($pipes[2]);
        fclose($pipes[2]);
    
        return [
            'code' => proc_close($process),
            'out' => trim($stdout),
            'err' => trim($stderr),
        ];
    }
    
    public function repoExists( $_gitBranch )
    {
        $gitCommand = sprintf( 'git ls-remote --heads origin %s', $_gitBranch );
        $gitResult = $this->repoExec( $gitCommand );
        
        return $gitResult;
    }
    
    public function repoCommit( $_gitBranch, $_gitMessage, $_gitOptions ) 
    {
        $gitCommand = 'git commit -m [options] "[message]"';
        $gitResult = $this->repoExec( $gitCommand );
        
        return $gitResult;
    }

    public function repoPush()
    {
        $git = exec('git ... 2>&1');
        
        return $git;
    }

    public function repoBranchCreate() 
    {
        return exec('git checkout -b [options] [branch] 2>&1');
    }

    public function repoBranchDelete( $_gitBranch, $_gitOptions )
    {
        return exec('git branch --delete [options] [branch] 2>&1');
    }

    public function repoBranchCheckout( $_gitBranch, $_gitOptions ) 
    {
        $gitCommand = sprintf( 'git checkout %s %s', $_gitOptions, $_gitBranch );
        $gitResult = $this->repoExec( $gitCommand );

        return $gitResult;
    }

    public function repoBranchReportStatus( $_gitOptions = '' ) 
    {
        $gitCommand = sprintf( 'git status %s', $_gitOptions );
        $gitResult = $this->repoExec( $gitCommand );
        
        return $gitResult;
    }

    public function repoBranchReportLastCommit()
    {
        $gitCommand = 'git log -1';
        $gitResult = $this->repoExec( $gitCommand );
        
        return $gitResult;
    }

}

?>