<?php

/**
 * Display one or all of the quotes on file.
 * 
 * controllers/Viewer.php
 *
 * ------------------------------------------------------------------------
 */
class Viewer extends Application {

    function __construct()
    {
	parent::__construct();
    }

    //-------------------------------------------------------------
    //  The normal pages
    //-------------------------------------------------------------

    function index()
    {
	$this->data['pagebody'] = 'homepage';    // this is the view we want shown
	$this->data['authors'] = $this->quotes->all();
        
	$this->render();
    }

    // method to display just a single quote
    function quote($id)
    {
	$this->data['pagebody'] = 'justone';    // this is the view we want shown
	$this->data = array_merge($this->data, (array) $this->quotes->get($id));
        
        //invoke the caboose
        $this->caboose->needed('jrating', 'hollywood');
        
        //adjust to the average
        $this->data['average'] = 
        ($this->data['vote_count'] > 0) ? 
        ($this->data['vote_total'] / $this->data['vote_count']) : 0;
        
	$this->render();
    }
    
    
    // handle a rating
    function rate() 
    {
        // detect non-AJAX entry
        if (!isset($_POST['action'])) redirect("/");

        // extract parameters
        $id = intval($_POST['idBox']);
        $rate = intval($_POST['rate']);

        // update the posting
        $record = $this->quotes->get($id);

        if ($record != null) 
        {
          $record->vote_total += $rate;
          $record->vote_count++;
          $this->quotes->update($record);
        }

        $response = 'Thanks for voting!';
        echo json_encode($response);	
    }


}



/* End of file Welcome.php */
/* Location: application/controllers/Welcome.php */