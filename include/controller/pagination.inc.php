<?php 
    namespace controller;
    
    class Pagination {

        private $_linesPerPage  = 0;
        private $_currentPage   = 0;
        private $_range         = 0;
        private $_totalPages    = 0;
        private $_totalLines    = 0;
        private $_prevPageString = null;
        private $_nextPageString = null;
        private $_rootNode = null;
        private $_childNode = null;
        private $_disabledChildNode = null;
        private $_activeChildNode = null;

        public function __construct(int $lines_per_page, int $current_page = 0, int $range ,int $total_lines, string $prevPageString, string $nextPageString) {

            $this->_linesPerPage = $lines_per_page;
            $this->_currentPage = $current_page;
            $this->_range = $range;
            $this->_totalLines = $total_lines;
            $this->_prevPageString = $prevPageString;
            $this->_nextPageString = $nextPageString;
            $this->_totalPages = ceil($total_lines/$lines_per_page); 
        }

        public function getHTML() : void {

            // TODO change to exceptio when the exception handling is completed
            if(is_null($this->_rootNode)) {

                trigger_error(__CLASS__." Error in ".__METHOD__.", _rootNode is null!", E_USER_ERROR);
                die();
            }

            $root = $this->_rootNode;

            if($this->_prevPageString != null) {
                if($this->_currentPage == 1) {
                    $disabledChildNode = $this->_disabledChildNode;
                    $disabledChildNode->documentElement->firstChild->textContent = $this->_prevPageString;
                    $root->documentElement->firstChild->appendChild($root->importNode($disabledChildNode->documentElement, true));
                    //$this->$_rootNode->appendChild((($this->_currentPage == 1) ? $this->$_disabledChildNode->$firstChild->textContent =  : $this->$_childNode));
                } else {
                    $childNode = $this->_childNode;
                    // TODO: User should set path and filename
                    $childNode->documentElement->firstChild->setAttribute('href', 'index.php?page='.($this->_currentPage-1));
                    $childNode->documentElement->firstChild->textContent = $this->_prevPageString;
                    $root->documentElement->firstChild->appendChild($root->importNode($childNode->documentElement, true));
                }
            } 
            
            if($this->_totalPages > $this->_range) {
                $start = ($this->_currentPage <= $this->_range) ? 1 :($this->_currentPage - $this->_range);
                $end = ($this->_totalPages - $this->_currentPage >= $this->_range)?($this->_currentPage + $this->_range):$this->_totalPages; 
            } else {
                $start = 1;
                $end = $this->_totalPages;
            }

            for($i = $start; $i <= $end; $i++) {
                $childNode = $this->_childNode;
                $activeChildNode = $this->_activeChildNode;

                if($i == $this->_currentPage) {
                    $activeChildNode->documentElement->firstChild->setAttribute('href', 'index.php?page='.$i);
                    $activeChildNode->documentElement->firstChild->textContent = $i;
                    $root->documentElement->firstChild->appendChild($root->importNode($activeChildNode->documentElement,true));
                } else {
                    $childNode->documentElement->firstChild->setAttribute('href', 'index.php?page='.$i);
                    $childNode->documentElement->firstChild->textContent = $i;
                    $root->documentElement->firstChild->appendChild($root->importNode($childNode->documentElement,true));
                }
                //$html .= '<li class="page-item'.(($i == $this->_currentPage) ? " active" : "").'"><a class="page-link text-white bg-dark" href="index.php?page='.$i.'">'.$i.'</a></li>';

            }

            if($this->_nextPageString != null) {
                if($this->_currentPage == $this->_totalPages) {
                    $disabledChildNode = $this->_disabledChildNode;
                    $disabledChildNode->documentElement->firstChild->textContent = $this->_prevPageString;
                    $root->documentElement->firstChild->appendChild($root->importNode($disabledChildNode->documentElement, true));
                    //$this->$_rootNode->appendChild((($this->_currentPage == 1) ? $this->$_disabledChildNode->$firstChild->textContent =  : $this->$_childNode));
                } else {
                    $childNode = $this->_childNode;
                    // TODO: User should set path and filename
                    $childNode->firstChild->setAttribute('href', 'index.php?page='.($this->_currentPage-1));
                    $childNode->documentElement->firstChild->textContent = $this->_nextPageString;
                    $root->documentElement->firstChild->appendChild($root->importNode($childNode->documentElement, true));
                }
                //$html .='<li class="page-item'.(($this->_currentPage == $this->_totalPages) ? " disabled" : "").'"><a class="page-link text-white bg-dark" href="'.(($this->_currentPage < $this->_totalPages) ? "index.php?page=".($this->_currentPage+1) : "#").'">'.$this->_nextPageString.'</a></li>';
            }

            echo html_entity_decode($root->saveHTML());
        }

        public function getCurrentPage() : int {
            return $this->_currentPage;
        }

        public function getLinesPerPage() : int {
            return $this->_linesPerPage;
        }

        public function setRootNode(\DOMDocument $rootNode) : void {
            $this->_rootNode = $rootNode;
        }

        public function setActiveChildNode(\DOMDocument $activeChildNode) : void {
            $this->_activeChildNode = $activeChildNode;
        }

        public function setChildNode(\DOMDocument $childNode) : void {
            $this->_childNode = $childNode;
        }

        public function setDisabledChildNode(\DOMDocument $disabledChildNode) : void {
            $this->_disabledChildNode = $disabledChildNode;
        }
    }
?>