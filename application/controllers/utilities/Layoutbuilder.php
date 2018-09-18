<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Author: Collins Mutugi Riungu
*		  colrium@gmail.com
*         @mutugiriungu
*
* Added Awesomeness: Fridah Gacheri Mugambi
*
* Requirements: PHP5 or above
*
*/
class Layoutbuilder extends CI_Controller {

	public $displayData;

	function __construct(){
		parent::__construct();
		isloggedin(TRUE);

		$this->displayData = array();
		$this->displayData['module'] = 'modules';
		$this->load->model('data', 'clsData');
		$this->load->helper('htmlbuilder');
	}



	function index(){
		html_builder();
		
	}

	function frontend(){
			$this->displayData['title']        = 'Dashboard';
		    $this->displayData['pageTitle']    = ''.CENUM_CHIP_POINTER.''.breadcrumb('Dashboard');
		    $this->displayData['mainTemplate'] = 'modules/dashboard';
		    $this->displayData['nav'] = $this->mnav_brain_jar->navData('modules');      
		    renderpage($this->displayData);
		    
	}

	public function simpleminimalisticsnippets(){
	    $snippets = '<div data-thumb="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/thumbnails/a01.png" data-cat="0,1">
	            <div class="row clearfix">
	              <div class="col s12">
	                <div class="display">
	                  <h1>Lorem Ipsum is simply dummy text of the printing and typesetting industry</h1>
	                </div>
	              </div>
	            </div>
	          </div>

	          <div data-thumb="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/thumbnails/c01.png" data-cat="0,3">
	            <div class="row clearfix">
	              <div class="col s12">
	                          <div class="display">
	                              <p style="font-size:1em">This is a special report</p>
	                              <h1 style="font-size:3.5em;margin:0.2em 0">Lorem Ipsum is simply dummy text of the printing industry</h1>
	                          </div>
	                    </div>
	            </div>
	          </div>

	          <div data-thumb="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/thumbnails/g01.png" data-cat="0,6">
	            <div class="row clearfix">
	              <div class="col s12">
	                          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus leo ante, consectetur sit amet vulputate vel, dapibus sit amet lectus.</p>
	                    </div>
	            </div>
	          </div>

	          <div data-thumb="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/thumbnails/e01.png" data-cat="0,5">
	            <div class="row clearfix">
	                    <div class="col s12">
	                          <h1>Heading 1 Text Goes Here</h1>
	                          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
	                    </div>
	                </div>
	          </div>

	          <div data-thumb="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/thumbnails/e02.png" data-cat="0,5">
	            <div class="row clearfix">
	                    <div class="col s12">
	                          <h2>Heading 2 Text Goes Here</h2>
	                          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
	                    </div>
	                </div>
	          </div>

	          <div data-thumb="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/thumbnails/e08.png" data-cat="0,5">
	            <div class="row clearfix">
	              <div class="col s4">
	                <h1>Beautiful Content</h1>
	                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.</p>
	              </div>
	              <div class="col s4">
	                <img src="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/e08-1.jpg" style="margin-right:1.5em">
	              </div>
	              <div class="col s4">
	                <img src="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/e08-2.jpg">
	              </div>
	            </div>
	          </div>

	          <div data-thumb="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/thumbnails/e09.png" data-cat="0,5">
	            <div class="row clearfix">
	              <div class="col s4">
	                <h1>Lorem Ipsum</h1>
	                <p>Lorem Ipsum is simply dummy text. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
	              </div>
	              <div class="col s8">
	                <img src="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/e09-1.jpg">
	              </div>
	            </div>
	          </div>
	          <div data-thumb="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/thumbnails/v01.png" data-cat="0,19">
	              <div class="row clearfix">
	                  <div class="col s12">
	                      <hr>
	                  </div>
	              </div>
	          </div>

	          <div data-thumb="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/thumbnails/v02.png" data-cat="0,19">
	              <div class="row clearfix">
	                  <div class="col s12">
	                      <br><br>
	                  </div>
	              </div>
	          </div>

	          <div data-thumb="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/thumbnails/b01.png" data-cat="0,2">
	            <div class="row clearfix">
	              <div class="col s12 display">
	                          <h1>Beautiful content. Responsive.</h1>
	                          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
	                    </div>
	            </div>
	          </div>

	          <div data-thumb="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/thumbnails/b12.png" data-cat="0,2">
	            <div class="row clearfix">
	              <div class="col s12">
	                <div class="centered">
	                  <img src="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/b12-1.jpg" class="circle">
	                </div>
	                <div class="display centered">
	                  <h1>Lorem Ipsum is Simply</h1>
	                  <p>Lorem Ipsum is simply dummy text</p>
	                </div>
	                <p style="text-align: centered">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus leo ante, consectetur sit amet vulputate vel, dapibus sit amet lectus.</p>
	              </div>
	            </div>
	          </div>

	          <div data-thumb="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/thumbnails/b14.png" data-cat="0,2">
	            <div class="row clearfix">
	              <div class="col s12">
	                <div class="display centered">
	                  <h1>Beautiful Content</h1>
	                  <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.</p>
	                  <br>
	                </div>
	                <div class="centered">
	                  <img src="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/b14-1.jpg"><img src="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/b14-2.jpg"><img src="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/b14-3.jpg">
	                </div>
	              </div>
	            </div>
	          </div>

	          <div data-thumb="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/thumbnails/g02.png" data-cat="0,6">
	            <div class="row clearfix">
	              <div class="col s6 flow-opposite">
	                          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
	                    </div>
	                    <div class="col s6">
	                          <img src="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/g02-1.jpg">
	                    </div>
	            </div>
	          </div>

	          <div data-thumb="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/thumbnails/g03.png" data-cat="0,6">
	            <div class="row clearfix">
	              <div class="col s6">
	                          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
	                     </div>
	                    <div class="col s6">
	                          <img src="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/g03-1.jpg">
	                    </div>
	            </div>
	          </div>

	          <div data-thumb="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/thumbnails/h01.png" data-cat="0,6">
	            <div class="row clearfix">
	              <div class="col s6">
	                          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
	                    </div>
	              <div class="col s6">
	                <img src="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/h01-1.jpg" class="circle" style="margin-right: 1.5em">
	                <img src="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/h01-2.jpg" class="circle" style="margin-right: 1.5em">
	                <img src="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/h01-3.jpg" class="circle">
	              </div>
	            </div>
	          </div>

	          <div data-thumb="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/thumbnails/h02.png" data-cat="0,6">
	            <div class="row clearfix">
	              <div class="col s6 flow-opposite">
	                          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
	                    </div>
	              <div class="col s6">
	                <img src="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/h02-1.jpg" class="circle" style="margin-right: 1.5em">
	                <img src="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/h02-2.jpg" class="circle" style="margin-right: 1.5em">
	                <img src="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/h02-3.jpg" class="circle">
	              </div>
	            </div>
	          </div>


	          <div data-thumb="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/thumbnails/o01.png" data-cat="0,12">
	            <div class="row clearfix">
	              <div class="row clearfix">
	                <div class="col s12">
	                            <img src="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/o01-1.jpg">
	                </div>
	              </div>
	            </div>
	          </div>


	          <div data-thumb="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/thumbnails/o03.png" data-cat="0,12">
	            <div class="row clearfix">
	              <div class="col s12">
	                          <figure class="hdr">
	                  <img src="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/o03-1.jpg">
	                  <div>
	                                    <figcaption>
	                        <h2>The <span>Cafe</span></h2>
	                        <p>Fresh roasted coffee, exclusive teas &amp; light meals</p>
	                        </figcaption> 
	                              </div>    
	                </figure>
	                    </div>
	            </div>
	          </div>

	          <div data-thumb="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/thumbnails/o04.png" data-cat="0,12">
	            <div class="row clearfix">
	              <div class="col s12">
	                         <figure class="hdr one">
	                  <img src="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/o04-1.jpg">
	                  <div>
	                                    <figcaption>
	                        <h2>The <span>Cafe</span></h2>
	                        <p>Fresh roasted coffee, exclusive teas &amp; light meals</p>
	                        </figcaption> 
	                              </div>    
	                </figure>
	                    </div>
	            </div>
	          </div>


	          <div data-thumb="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/thumbnails/k06.png" data-cat="0,9">
	            <div class="row clearfix">
	              <div class="col s3 centered">
	                <img src="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/k06-1.jpg">
	              </div>
	              <div class="col s3">
	                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.</p>
	              </div>
	              <div class="col s3 centered">
	                <img src="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/k06-2.jpg">
	              </div>
	              <div class="col s3">
	                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.</p>
	              </div>
	            </div>
	          </div>

	          <div data-thumb="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/thumbnails/k02.png" data-cat="0,9">
	            <div class="row clearfix">
	              <div class="col s4">
	                          <figure>
	                  <img src="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/k02-1.jpg">
	                              <figcaption>
	                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
	                  </figcaption> 
	                </figure>
	                    </div>
	                    <div class="col s4">
	                          <figure>
	                  <img src="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/k02-2.jpg">
	                              <figcaption>
	                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
	                  </figcaption> 
	                </figure>
	                    </div>
	                    <div class="col s4">
	                          <figure>
	                  <img src="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/k02-3.jpg">
	                              <figcaption>
	                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
	                  </figcaption> 
	                </figure>
	                    </div>
	            </div>
	          </div>

	          <div data-thumb="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/thumbnails/k01.png" data-cat="0,9">
	            <div class="row clearfix">
	              <div class="col s6">
	                          <figure>
	                  <img src="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/k01-1.jpg">
	                              <figcaption>
	                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
	                  </figcaption> 
	                </figure>
	                    </div>
	                    <div class="col s6">
	                          <figure>
	                  <img src="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/k01-2.jpg">
	                              <figcaption>
	                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
	                  </figcaption> 
	                </figure>
	                    </div>
	            </div>
	          </div>

	          <div data-thumb="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/thumbnails/p01.png" data-cat="0,13">
	            <div class="row clearfix">
	              <div class="col s6 flow-opposite">
	                        <div class="display">
	                              <h1>Beautiful content. Responsive.</h1>
	                              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
	                              <div style="margin:1em 0 2.5em;">
	                                <a href="#" class="btn edit">Read More</a>
	                              </div>
	                          </div>
	                    </div>
	                    <div class="col s6">
	                          <img src="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/p01-1.jpg">
	                    </div>
	            </div>
	          </div>

	          <div data-thumb="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/thumbnails/p02.png" data-cat="0,13">
	            <div class="row clearfix">
	              <div class="col s6">
	                          <div class="display">
	                              <h1>Beautiful content. Responsive.</h1>
	                              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
	                              <div style="margin:1em 0 2.5em;">
	                                <a href="#" class="btn edit">Read More</a>
	                              </div>
	                          </div>
	                    </div>
	                    <div class="col s6">
	                          <img src="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/p02-1.jpg">
	                    </div>
	            </div>
	          </div>

	          <div data-thumb="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/thumbnails/p03.png" data-cat="0,13">
	            <div class="row clearfix">
	              <div class="col s6 flow-opposite">
	                          <h1>Beautiful content. Responsive.</h1>
	                          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
	                          <div style="margin:1em 0 2.5em;">
	                            <a href="#" class="btn edit">Read More</a>
	                          </div>
	                    </div>
	                    <div class="col s6">
	                          <img src="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/p03-1.jpg">
	                    </div>
	            </div>
	          </div>

	          <div data-thumb="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/thumbnails/p04.png" data-cat="0,13">
	            <div class="row clearfix">
	              <div class="col s6">
	                          <h1>Beautiful content. Responsive.</h1>
	                          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
	                          <div style="margin:1em 0 2.5em;">
	                            <a href="#" class="btn edit">Read More</a>
	                          </div>
	                    </div>
	                    <div class="col s6">
	                          <img src="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/p04-1.jpg">
	                    </div>
	            </div>
	          </div>

	          <div data-thumb="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/thumbnails/p05.png" data-cat="0,13">
	            <div class="row clearfix">
	                  <div class="col s12">
	                      <div class="display centered">
	                          <h1>Beautiful content. Responsive.</h1>
	                          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
	                      </div>
	                   </div>
	              </div>
	              <div class="row clearfix">
	                  <div class="col s12 centered">
	                      <div style="margin:1em 0 2.5em;">
	                      <a href="#" class="btn edit">Read More</a>
	                      </div>
	                  </div>
	              </div>
	          </div>

	          <div data-thumb="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/thumbnails/p06.png" data-cat="0,13">
	           <div class="row clearfix">
	                  <div class="col s12">
	                      <div class="display centered">
	                          <h1 style="font-size:4em">Lorem Ipsum is simply dummy text of the printing and typesetting industry</h1>
	                      </div>
	                      <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
	                  </div>
	              </div>
	              <div class="row clearfix">
	                  <div class="col s12 centered">
	                      <div style="margin:1em 0 2.5em;">
	                      <a href="#" class="btn edit">Read More</a>
	                      </div>
	                  </div>
	              </div>
	          </div>

	          <div data-thumb="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/thumbnails/p07.png" data-cat="0,13">
	           <div class="row clearfix">
	                  <div class="col s12 centered">
	                      <div style="margin:1em 0 2.5em;">
	                      <a href="#" class="btn btn-default edit">Read More</a> &nbsp;
	                      <a href="#" class="btn edit">Download</a>
	                      </div>
	                  </div>
	              </div>
	          </div>

	          <div data-thumb="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/thumbnails/q01.png" data-cat="0,14">
	              <div class="row clearfix">
	                  <div class="col s6">
	                      <div class="list">
	                          <i class="icon-ok"></i>
	                          <h3>Feature Item</h3>
	                          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
	                      </div>
	                  </div>
	                  <div class="col s6">
	                      <div class="list">
	                          <i class="icon-ok"></i>
	                          <h3>Feature Item</h3>
	                          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
	                      </div>
	                  </div>
	              </div>  
	          </div>

	          <div data-thumb="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/thumbnails/q02.png" data-cat="0,14">
	              <div class="row clearfix">
	                  <div class="col s4">
	                      <div class="list">
	                          <i class="icon-ok"></i>
	                          <h3>Feature Item</h3>
	                          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
	                      </div>
	                  </div>
	                  <div class="col s4">
	                      <div class="list">
	                          <i class="icon-ok"></i>
	                          <h3>Feature Item</h3>
	                          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
	                      </div>
	                  </div>
	                  <div class="col s4">
	                      <div class="list">
	                          <i class="icon-ok"></i>
	                          <h3>Feature Item</h3>
	                          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
	                      </div>
	                  </div>
	              </div>  
	          </div>

	          <div data-thumb="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/thumbnails/r01.png" data-cat="0,15">
	              <div class="row clearfix">
	                  <div class="col s12">
	                      <div class="quote">
	                          <i class="icon-quote"></i>
	                        <p>Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
	                          <small>by Albert Einstein</small>
	                      </div>
	                  </div>
	              </div>
	          </div>

	          <div data-thumb="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/thumbnails/r02.png" data-cat="0,15">
	              <div class="row clearfix">
	                  <div class="col s6">
	                      <div class="quote">
	                          <i class="icon-quote"></i>
	                        <p>Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
	                          <small>by Albert Einstein</small>
	                      </div>
	                  </div>
	                  <div class="col s6">
	                      <div class="quote">
	                          <i class="icon-quote"></i>
	                        <p>Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
	                          <small>by Albert Einstein</small>
	                      </div>
	                  </div>
	              </div>
	          </div>

	          <div data-thumb="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/thumbnails/r03.png" data-cat="0,15">
	            <div class="row clearfix">
	              <div class="col s6 flow-opposite">
	                          <div class="quote">
	                              <i class="icon-quote"></i>
	                            <p>Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
	                              <small>by Albert Einstein</small>
	                          </div>
	                    </div>
	                    <div class="col s6 centered">
	                          <img src="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/r03-1.jpg" class="circle" style="margin-top:1.5em">
	                    </div>
	            </div>
	          </div>

	          <div data-thumb="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/thumbnails/r04.png" data-cat="0,15">
	            <div class="row clearfix">
	              <div class="col s6 vh-centered full-height">
	                          <div class="quote">
	                              <i class="material-icons">format_quote</i>
	                            <p>Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
	                              <small>by Albert Einstein</small>
	                          </div>
	                    </div>
	                    <div class="col s6 vh-centered">
	                          <img src="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/r04-1.jpg" class="circle">
	                    </div>
	            </div>
	          </div>


	          <div data-thumb="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/thumbnails/s01.png" data-cat="0,16">
	            <div class="row clearfix">
	              <div class="col s2 flow-opposite">
	                          <p>
	                            <b>Sara Phillipps</b><br>A freelance web designer &amp; developer based in Melbourne, Australia.
	                          </p>
	                          <div class="social edit">
	                              <a href="https://twitter.com/"><i class="icon-twitter"></i></a>
	                              <a href="https://www.facebook.com/"><i class="icon-facebook"></i></a>
	                              <a href="https://plus.google.com/"><i class="icon-googleplus"></i></a>
	                              <!--<a href="#"><i class="icon-github"></i></a>
	                              <a href="#"><i class="icon-dribbble"></i></a>
	                              <a href="#"><i class="icon-pinterest"></i></a>
	                              <a href="#"><i class="icon-linkedin"></i></a>
	                              <a href="#"><i class="icon-instagram"></i></a>-->
	                              <a href="mailto:you@example.com"><i class="icon-mail"></i></a>
	                        </div>
	                    </div>
	                    <div class="col s10 centered">
	                          <img src="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/s01-1.jpg" class="circle" style="margin-top:1.2em">
	                    </div>
	            </div>
	          </div>


	          <div data-thumb="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/thumbnails/s03.png" data-cat="0,16">
	            <div class="row clearfix">
	              <div class="col s4 center flow-opposite">
	                <h2>Lorem Ipsum</h2>
	                          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.</p>
	                <div class="social edit">
	                              <a href="https://twitter.com/"><i class="icon-twitter"></i></a>
	                              <a href="https://www.facebook.com/"><i class="icon-facebook"></i></a>
	                              <a href="https://plus.google.com/"><i class="icon-googleplus"></i></a>
	                              <a href="mailto:you@example.com"><i class="icon-mail"></i></a>
	                </div>
	                    </div>
	              <div class="col s8">
	                <img src="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/s03-1.jpg">
	              </div>
	            </div>
	          </div>


	          <div data-thumb="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/thumbnails/s10.png" data-cat="0,16">
	            <div class="row clearfix">
	              <div class="col s6">
	                <div class="col s4 centered">
	                  <img src="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/s10-1.jpg" class="circle" style="margin-top:1.5em">
	                </div>
	                <div class="col s8">
	                  <p>Lorem Ipsum is simply dummy text of the printing industry.</p>
	                  <div class="social edit">
	                                <a href="https://twitter.com/"><i class="icon-twitter"></i></a>
	                                <a href="https://www.facebook.com/"><i class="icon-facebook"></i></a>
	                                <a href="https://plus.google.com/"><i class="icon-googleplus"></i></a>
	                                <a href="mailto:you@example.com"><i class="icon-mail"></i></a>
	                  </div>
	                </div>
	              </div>
	              <div class="col s6">
	                <div class="col s4 centered">
	                  <img src="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/s10-2.jpg" class="circle" style="margin-top:1.5em">
	                </div>
	                <div class="col s8">
	                  <p>Lorem Ipsum is simply dummy text of the printing industry.</p>
	                  <div class="social edit">
	                                <a href="https://twitter.com/"><i class="icon-twitter"></i></a>
	                                <a href="https://www.facebook.com/"><i class="icon-facebook"></i></a>
	                                <a href="https://plus.google.com/"><i class="icon-googleplus"></i></a>
	                                <a href="mailto:you@example.com"><i class="icon-mail"></i></a>
	                  </div>
	                </div>
	              </div>
	            </div>
	          </div>

	          <div data-thumb="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/thumbnails/t01.png" data-cat="0,17">
	              <div class="row clearfix">
	                  <div class="col s12">
	                      <div class="embed-responsive embed-responsive-16by9">
	                      <iframe width="100%" height="400" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" class="mg1" src="https://maps.google.com/maps?q=Melbourne,+Victoria,+Australia&amp;hl=en&amp;sll=-7.981898,112.626504&amp;sspn=0.009084,0.016512&amp;oq=melbourne&amp;hnear=Melbourne+Victoria,+Australia&amp;t=m&amp;z=10&amp;output=embed"></iframe>
	                      </div>
	                  </div>
	              </div>
	          </div>

	          <div data-thumb="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/thumbnails/t02.png" data-cat="0,17">
	              <div class="row clearfix">
	                  <div class="col s4 flow-opposite">
	                      <h3>Get in Touch</h3>
	                      <p>
	                        <strong>Company, Inc.</strong><br>
	                        123 Street, City<br>
	                        State 12345<br>
	                        P: (123) 456 7890 / 456 7891
	                      </p>

	                      <p>
	                        <strong>Full Name</strong><br>
	                        <a href="mailto:#">first.last@example.com</a>
	                      </p>
	                  </div>
	                  <div class="col s8">
	                      <div class="embed-responsive embed-responsive-16by9">
	                      <iframe width="100%" height="400" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" class="mg1" src="https://maps.google.com/maps?q=Melbourne,+Victoria,+Australia&amp;hl=en&amp;sll=-7.981898,112.626504&amp;sspn=0.009084,0.016512&amp;oq=melbourne&amp;hnear=Melbourne+Victoria,+Australia&amp;t=m&amp;z=10&amp;output=embed"></iframe>
	                      </div>
	                  </div>
	              </div>
	          </div>

	          <div data-thumb="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/thumbnails/o02.png" data-cat="0,20">
	            <div class="row clearfix">
	                    <div class="col s12">
	                          <div class="embed-responsive embed-responsive-16by9">
	                            <iframe width="560" height="315" src="//www.youtube.com/embed/P5yHEKqx86U?rel=0" frameborder="0" allowfullscreen=""></iframe>
	                          </div>
	                    </div>
	                </div>
	          </div>

	          <div data-thumb="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/thumbnails/e13.png" data-cat="0,5,20">
	            <div class="row clearfix">
	                    <div class="col s6 flow-opposite">
	                          <h3>Lorem Ipsum is simply dummy text</h3>
	                          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
	                    </div>
	                    <div class="col s6 centered">
	                          <div class="embed-responsive embed-responsive-4by3">
	                            <iframe width="560" height="315" src="//www.youtube.com/embed/P5yHEKqx86U?rel=0" frameborder="0" allowfullscreen=""></iframe>
	                          </div>
	                    </div>
	                </div>
	          </div>

	          <div data-thumb="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/thumbnails/e14.png" data-cat="0,5,20">
	            <div class="row clearfix">
	                    <div class="col s6">
	                          <h3>Lorem Ipsum is simply dummy text</h3>
	                          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
	                    </div>
	                    <div class="col s6">
	                          <div class="embed-responsive embed-responsive-4by3">
	                            <iframe width="560" height="315" src="//www.youtube.com/embed/P5yHEKqx86U?rel=0" frameborder="0" allowfullscreen=""></iframe>
	                          </div>
	                    </div>
	                </div>
	          </div>

	          <div data-thumb="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/thumbnails/u04.png" data-cat="0,18">
	            <div class="row clearfix">
	              <div class="col s12 centered">
	                <div class="col fifth">
	                  <div style="background-color: #00bfff">
	                    <a href="https://twitter.com/" style="color:#ffffff"><i style="font-size:60px" class="icon-twitter"></i></a>
	                  </div>
	                </div>
	                <div class="col fifth">
	                  <div style="background-color: #128BDB;">
	                    <a href="https://facebook.com/" style="color:#ffffff"><i style="font-size:60px" class="icon-facebook"></i></a>
	                  </div>
	                </div>
	                <div class="col fifth">
	                  <div style="background-color: #E20000;">
	                    <a href="https://www.youtube.com/" style="color:#ffffff"><i style="font-size:60px" class="icon-youtube"></i></a>
	                  </div>
	                </div>
	                <div class="col fifth">
	                  <div style="background-color: #0569AA;">
	                    <a href="http://www.website.com/" style="color:#ffffff"><i style="font-size:60px" class="icon-home"></i></a>
	                  </div>
	                </div>
	                <div class="col fifth">
	                  <div style="background-color: #ff69B4">
	                    <a href="mailto:you@example.com" style="color:#ffffff"><i style="font-size:60px" class="icon-mail"></i></a>
	                  </div>
	                </div>
	              </div>
	            </div>
	          </div>

	          <!-- End of Default -->

	          <div data-thumb="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/thumbnails/n15.png" data-cat="11">
	            <div class="row clearfix">
	              <div class="col s6">
	                <img src="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/k01-1.jpg">
	                  </div>
	                  <div class="col s6">
	                <img src="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/k01-2.jpg">
	                  </div>
	            </div>
	          </div>

	          <div data-thumb="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/thumbnails/n16.png" data-cat="11">
	            <div class="row clearfix">
	                <div class="col s4">
	                      <img src="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/k02-1.jpg"> 
	                  </div>
	                  <div class="col s4">
	                <img src="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/k02-2.jpg">
	                  </div>
	                  <div class="col s4">
	                <img src="'.CENUM_ASSETS_DIR.'contentbuilder/snippets/minimalist-basic/k02-3.jpg">
	                  </div>
	            </div>
	          </div>';
	      echo $snippets;   
	  }


	public function dynamiccontent(){
		$data = '<h1>It\'s dynamic content</h1>';
		echo $data;
	}

	public function materialsvgbg(){
		$svg = '<svg  xmlns="http://www.w3.org/2000/svg"  width="100%" height="100%" viewBox="0 0 1000 500">
			<defs>
				<clipPath id="tabclippath" clipPathUnits="objectBoundingBox">
		            <path d="M 0,1 L 0,1 0.1,0.25 Q 0.13,0 0.18,0 L 0.18,0 0.82,0 Q 0.87,0 0.9,0.25 L 0.9,0.25 1,1  0,1"/>
		        </clipPath>
				<linearGradient id="mdsvgdropshadow" gradientTransform="rotate(39.5)">
					<stop offset="67%"  stop-color="#000000" stop-opacity="1"/>
					<stop offset="75%" stop-color="rgba(0,0,0,0)" stop-opacity="1"/>
				</linearGradient>
			</defs>
		    	<polygon class="primary" fill="#00bcd4" points="700,0 1000,0 1000,500 200,500 700,0" style="fill: '.getcolor(0).'"/>
				<polygon class="accentShadow"  points="700,0 800,0 300,500 200,500 700,0" fill="url(#mdsvgdropshadow)"/>
				<polygon class="accent"  fill="#ff0000" points="550,0 750,0 250,500 50,500 550,0" style="fill: '.getcolor(2).'"/>
				<polygon class="primaryDark" fill="#00bcd4" points="0,0 200,0 1000,500 0,500 0,0"  style="fill: '.getcolor(1).'"/>
				<polygon class="primaryShadow" points="550,0 650,0 150,500 50,500 550,0"  fill="url(#mdsvgdropshadow)"/>
				<polygon class="primary" fill="#00bcd4" points="0,0 600,0 100,500 0,500 0,0" style="fill: '.getcolor().'"/>
		</svg>';
		header('Content-type: image/svg+xml');

		echo $svg;

	}

	public function polygonssvg($width=1280, $height=720, $polwidth=150, $polheight=100){
		$startx = 0;
		$starty = 0;
		$variance = 1;
		$vertices = array();

		//generate vertices
		for ($x=0; $x <= $width; $x += $polwidth) { 
			$newvertice = array();
			for ($y=0; $y <= $height; $y+=$polheight) { 
				$newvertice['x'] = ((100 * $x / $width * $width / $variance)-($polwidth/$variance*2))/100;
				$newvertice['y'] = ((100 * $y / $height * $height / $variance)-($polheight/$variance*2))/100;
				array_push($vertices, $newvertice);
			}
				
		}
		for ($i=0; $i < sizeof($vertices); $i++) { 
			echo "X: ".$vertices[$i]['x'].' Y: '.$vertices[$i]['y'].'</br>';
		}

	}








}
