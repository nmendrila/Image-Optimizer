<?php
    /**
     * A wrapper for the TinyJPG/TinyPNG PHP client
     */
    class ImageOptimizer {
        private $imagesFolder;
        private $messages = array();
        private $optimizedSuffix;
        private $allowedFormats = array();

        public function __construct($apiKey)
        {            
            $this->setApiKey($apiKey);
            $this->setImagesFolder(getcwd() . '/images/');
            $this->setoptimizedSuffix('-opt');
            $this->setAllowedFormats(array('jpeg', 'jpg', 'png'));
        }

        public function setApiKey($apiKey) 
        {
            \Tinify\setKey($apiKey);
        }

        public function setImagesFolder($folder) 
        {
            $this->imagesFolder = $folder;
        }

        public function setoptimizedSuffix($suffix) {
            $this->optimizedSuffix = $suffix;
        }

        public function setAllowedFormats($formats) {
            $this->allowedFormats = $formats;
        }

        public function processImages($showMessages = true) 
        {
            $images = $this->getAllImagesToProcess();

            if (count($images) > 0) {               
                try {
                    foreach ($images as $image) {
                        $this->processImage($image);                        
                    } 
                } catch(Exception $e) {
                    $this->addMessage('Error: ' . $e->getMessage());
                }
            } else {
                $this->addMessage('No images found.');
            }

            if ($showMessages === true) {
                $this->outputMessages();
            }
        }

        private function processImage($image) 
        {
            $imageParts     = pathinfo($image);
            $toFile         = $imageParts['filename'] . $this->optimizedSuffix . '.' . $imageParts['extension'];
            $toFilePath     = $this->imagesFolder . $toFile;

            if (!file_exists($toFilePath) && strpos($image, $this->optimizedSuffix) === false) {
                $this->writeOutputFile($this->getInputFile($image), $toFilePath);
                $this->addMessage('Image processed: ' . $image);   
            } else {
                $this->addMessage('Image not processed: ' . $image); 
            }      
        }

        private function getInputFile($image)
        {
            return \Tinify\fromFile($this->imagesFolder . $image);
        }

        private function getAllImagesToProcess() 
        {
            $images = array();
            
            if ($handle = opendir($this->imagesFolder)) {
                while (false !== ($entry = readdir($handle))) {
                    $extension = pathinfo($entry, PATHINFO_EXTENSION);

                    if ($entry != "." && $entry != ".." && in_array($extension, $this->allowedFormats)) {
                        $images[] = $entry;
                    }
                }
        
                closedir($handle);
            }
        
            return $images;
        }

        private function writeOutputFile($source, $toFile) 
        {
            $source->toFile($toFile);
        }        

        private function addMessage($message) 
        {
            $this->messages[] = $message;
        }

        private function outputMessages() 
        {
            $lineBreak = PHP_SAPI === "cli" ? "\n" : "<br />";

            foreach ($this->messages as $message) {
                echo $message . $lineBreak;
            }
        }
    }