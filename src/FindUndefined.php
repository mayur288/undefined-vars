<?php

class ReadCode {
    private array $_tokens;
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
        
        $obj = new ReadCode( $this->extractFunctionsFromCode() );
        //$obj->
        // return $this->getUndefinedVars();
        return [];
    }

    public function extractFunctionsFromCode() {
        preg_match_all( '/function[\s\n]+([a-zA-z0-9_]+)[\s\n]*\(/' , $this->getFileSource() , $matched );
        return !empty( $matched ) && isset( $matched[1] ) ? $matched[1] : [];
    }

    public function getFileSource() {
        return file_get_contents( $this->getFilePath() );
    }

    public function extractFunctionSource() {
        
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
