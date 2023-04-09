<?php

class ReadCode {
    private ?string $_filePath;
    private array $_methodNames;
    private array $_methodVariables;
    private array $_methodStack;
    private bool $_methodStart;
    private bool $_methodEnd;
    private bool $_methodInnerBlock;

    public function __construct( $filePath ) {
        $this->_filePath = $filePath;
        $this->_methodNames = [];
        $this->_methodStack = [];
    }

    public function addMethodName( $methodName ) {
        $this->_methodNames[$methodName] = [];
    }

    public function isMethodStart( $token ) { 
        return $token->getTokenName() == 'T_FUNCTION';
    }

    public function createMethodStack( $token ) {
        if( $token->getTokenName() == 'T_VARIABLE' ) {
            $this->_methodVariables[$token->text] = 0;
        } else if( $token->getTokenName() == '{' ) {
            return false;
        }
        return true;
    }

    public function checkUndefinedVariables( $token ) {

    }
    public function findVariables() {
        $this->_methodStart = $this->_methodEnd = $this->_methodInnerBlock = false;
        foreach( $this->getAllTokens() as $token ) {
           // echo "Line {$token->line}: {$token->getTokenName()} ('{$token->text}')", PHP_EOL;
            if( $this->isMethodStart( $token ) ) {
                $this->_methodStart = true;
            } else if( $this->_methodStart = true ) {
                $this->_methodStart = $this->createMethodStack( $token );
                $this->_methodInnerBlock = true;
            } else if( $this->_methodInnerBlock ) {
                $this->checkUndefinedVariables( $token );
            }



        }
    }

    public function getAllTokens() {
        return PhpToken::tokenize( file_get_contents( $this->_filePath ) );
    }
}

class ParseFile {
    private ?string $_filePath;
    private array $_undefinedVars;

    public function __construct( $filePath ) {
        $this->_filePath = $filePath;
    }

    public function getFilePath() {
        return $this->_filePath;
    }
    
    public function getUndefinedVars() {
        return $this->_undefinedVars;
    }

    public function parse(): array | null {
        echo 'Processing file : ' . $this->getFilePath() . PHP_EOL;
        
        $readCode = new ReadCode( $this->getFilePath() );
        $readCode->findVariables();
        
        //$obj->
        // return $this->getUndefinedVars();
        return [];
    }
}

class FindUndefined {

    private ?string $_path;
    private ?string $_outputPath;
    private bool $_isFile;
    private bool $_verbose;
    private ?string $_outputFileName;

    public  function __construct() {
        $this->_path = './../samples';
        $this->_outputPath = '/output';
        $this->_isFile = false;
        $this->_verbose = true;
        $this->_outputFileName = 'output.csv';
    }

    public function setPathToScan( $directoryToScan ) {
        $this->_isFile = is_file( $directoryToScan );
        $this->_path = $directoryToScan;
    }

    public function setOutputPath( $outputPath ) {
        $this->_outputPath = $outputPath;
    }

    public function setShowOutput( $showOutput ) {
        $this->_verbose = $showOutput;
    }

    public function setOutputFileName( $outPutFileName ) {
        $this->_outputFileName = $outPutFileName;
    }

    public function getPathToScan() {
        return $this->_path;
    }

    public function getOutputPath() {
        return $this->_outputPath;
    }

    public function getIsFile() {
        return $this->_isFile;
    }

    public function getShowOutput() {
        return $this->_verbose;
    }

    public function getOutputFileName() {
        return $this->_outputFileName;
    }

    public function findUndefinedVars() {
        if( $this->getIsFile() ) {
            $obj = new ParseFile( $this->getPathToScan() );
            $obj->parse();
        } else {
            $directoryIterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator( $this->getPathToScan(), RecursiveDirectoryIterator::UNIX_PATHS | RecursiveDirectoryIterator::SKIP_DOTS ), 
            RecursiveIteratorIterator::LEAVES_ONLY );
            foreach( $directoryIterator as $fileInfo ) {
                $filePath = $fileInfo->getPath() . '/' . $fileInfo->getFilename();
                $obj = new ParseFile( $filePath );
                $obj->parse();
            }
        }
    }
}

$obj = new FindUndefined();
$obj->setPathToScan( './../samples/ClassTest.php' );
$obj->setOutputFileName( 'output.csv' );
$obj->setOutputPath( './../output/' );
$obj->setShowOutput( $verbose = true );
$obj->findUndefinedVars();
