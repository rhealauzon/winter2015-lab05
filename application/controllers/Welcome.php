<?php

/**
 * Our homepage. Show the most recently added quote.
 * 
 * controllers/Welcome.php
 *
 * ------------------------------------------------------------------------
 */
class Welcome extends Application {

    function __construct()
    {
	parent::__construct();
    }

    //-------------------------------------------------------------
    //  The normal pages
    //-------------------------------------------------------------

    function index()
    {
	$this->data['pagebody'] = 'justone';    // this is the view we want shown
	
        //randomize the home page
        $choice = rand(1, $this->quotes->size());
        $this->data = array_merge($this->data, (array) $this->quotes->get($choice));
	
        
        //invoke the caboose
        $this->caboose->needed('jrating', 'hollywood');
        
        //adjust to the average
        $this->data['average'] = 
        ($this->data['vote_count'] > 0) ? 
        ($this->data['vote_total'] / $this->data['vote_count']) : 0;
        
        $this->render();
    }

}

/* End of file Welcome.php */
/* Location: application/controllers/Welcome.php */