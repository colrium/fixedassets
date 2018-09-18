<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
// copyright (c) 2016  Collins Riungu
//
// author: Mutugi Riungu

---------------------------------------------------------------------*/

?>
<div class="row" id="gradientbganim">
    <div class="col l4 m3 s1"></div>
		<div class="col l4 m6 s10 white rounded-5px step-up-3 border-anim">
			<?php
				$userimage = headerTxt(2, maticon('person_outline', 'large accent-text'), 'class="full-width center-align"');
				if (dbhasmainimage('users', USERID)) {
					$userimage = '<img src="'.site_url('files/Files/outputmainimage/users/'.USERID).'" class="large-image circle"/>';
				}


				$loginLayout = form_open('Login/unlock');

				$loginLayout .='<div class="row">';
					$loginLayout .='<div class="col l12 s12 m12 margin-top-x1">';
						$loginLayout .= maticon('lock_open', getcolorclass(4));
					$loginLayout .='</div>';
				$loginLayout .='</div>';


				$loginLayout .='<div class="row">';
					$loginLayout .='<div class="col l12 s12 m12 center-align margin-top-x1">';
						$loginLayout .= '<center>'.$userimage.'</center>';
					$loginLayout .='</div>';

					$loginLayout .='<div class="col l12 s12 m12 center-align margin-top-x1">';
						$loginLayout .= headerTxt('3', humanize(USERLNAME.' '.USERFNAME), 'class="full-width center-align"');
					$loginLayout .='</div>';
				$loginLayout .='</div>';




				$loginLayout .='<div class="row">';
					$loginLayout .='<div class="col s12">';
						$loginLayout .= materializeinputiconpass('',  'password', 'Password', 'vpn_key');
					$loginLayout .='</div>';
				$loginLayout .='</div>';


				$loginLayout .='<div class="row">';
					$loginLayout .='<div class="col s12 margin-top-x3 center-align">';
						$loginLayout .= mdlsubmitbtn('lock_open', 'Unlock');
					$loginLayout .='</div>';

				$loginLayout .='</div>';

				$loginLayout .= '</form>';
				echo $loginLayout;
			?>
		</div>
    <div class="col l4 m3 s1"></div>


	
</div>
<script>

$(document).ready(function(){


	function particlesbg(targetid, type){
    var lines, bubbles, nasa;
        lines = {
              "particles": {
                "number": {
                  "value": 60
                },
                "color": {
                  "value": "<?php echo getcolor(2); ?>"
                },
                "shape": {
                  "type": "polygon",
                  "stroke": {
                    "width": 0,
                    "color": "<?php echo getcolor(2); ?>"
                  },
                  "polygon": {
                    "nb_sides": 5
                  },
                  "image": {
                    "src": "img/github.svg",
                    "width": 100,
                    "height": 100
                  }
                },
                "opacity": {
                  "value": 0.3,
                  "random": false,
                  "anim": {
                    "enable": false,
                    "speed": 1,
                    "opacity_min": 0.1,
                    "sync": false
                  }
                },
                "size": {
                  "value": 3,
                  "random": true,
                  "anim": {
                    "enable": true,
                    "speed": 5,
                    "size_min": 0.1,
                    "sync": true
                  }
                },
                "line_linked": {
                  "enable": true,
                  "distance": 150,
                  "color": "<?php echo getcolor(2); ?>",
                  "opacity": 0.3,
                  "width": 1
                },
                "move": {
                  "enable": true,
                  "speed": 1,
                  "direction": "none",
                  "random": false,
                  "straight": false,
                  "out_mode": "bounce",
                  "attract": {
                    "enable": true,
                    "rotateX": 600,
                    "rotateY": 1200
                  }
                }
              },
              "interactivity": {
                "detect_on": "window",
                "events": {
                  "onhover": {
                    "enable": true,
                    "mode": "bubble"
                  },
                  "onclick": {
                    "enable": true,
                    "mode": "push"
                  },
                  "resize": true
                },
                "modes": {
                  "grab": {
                    "distance": 400,
                    "line_linked": {
                      "opacity": 1
                    }
                  },
                  "bubble": {
                    "distance": 100,
                    "size": 5,
                    "duration": 2,
                    "opacity": 8,
                    "speed": 1
                  },
                  "repulse": {
                    "distance": 200,
                    "duration": 0.4
                  },
                  "push": {
                    "particles_nb": 4
                  },
                  "remove": {
                    "particles_nb": 2
                  }
                }
              },
              "retina_detect": false,
              "config_demo": {
                "hide_card": false,
                "background_color": "#b61924",
                "background_image": "",
                "background_position": "50% 50%",
                "background_repeat": "no-repeat",
                "background_size": "cover"
              }
            };
        bubbles = {
                "particles": {
                  "number": {
                    "value": 2,
                    "density": {
                      "enable": true,
                      "value_area": 400
                    }
                  },
                  "color": {
                    "value": "<?php echo getcolor(2); ?>"
                  },
                  "shape": {
                    "type": "polygon",
                    "stroke": {
                      "width": 0,
                      "color": "#000"
                    },
                    "polygon": {
                      "nb_sides": 6
                    },
                    "image": {
                      "src": "img/github.svg",
                      "width": 100,
                      "height": 100
                    }
                  },
                  "opacity": {
                    "value": 0.2,
                    "random": true,
                    "anim": {
                      "enable": false,
                      "speed": 7,
                      "opacity_min": 0.1,
                      "sync": false
                    }
                  },
                  "size": {
                    "value": 50,
                    "random": true,
                    "anim": {
                      "enable": true,
                      "speed": 10,
                      "size_min": 40,
                      "sync": false
                    }
                  },
                  "line_linked": {
                    "enable": false,
                    "distance": 200,
                    "color": "<?php echo getcolor(2); ?>",
                    "opacity": 1,
                    "width": 2
                  },
                  "move": {
                    "enable": true,
                    "speed": 3,
                    "direction": "none",
                    "random": false,
                    "straight": false,
                    "out_mode": "out",
                    "bounce": true,
                    "attract": {
                      "enable": false,
                      "rotateX": 600,
                      "rotateY": 1200
                    }
                  }
                },
                "interactivity": {
                  "detect_on": "canvas",
                  "events": {
                    "onhover": {
                      "enable": true,
                      "mode": "push"
                    },
                    "onclick": {
                      "enable": true,
                      "mode": "grab"
                    },
                    "resize": true
                  },
                  "modes": {
                    "grab": {
                      "distance": 400,
                      "line_linked": {
                        "opacity": 1
                      }
                    },
                    "bubble": {
                      "distance": 400,
                      "size": 40,
                      "duration": 2,
                      "opacity": 8,
                      "speed": 3
                    },
                    "repulse": {
                      "distance": 200,
                      "duration": 0.4
                    },
                    "push": {
                      "particles_nb": 4
                    },
                    "remove": {
                      "particles_nb": 2
                    }
                  }
                },
                "retina_detect": true
    };

    nasa = {
          "particles": {
            "number": {
              "value": 50,
              "density": {
                "enable": true,
                "value_area": 800
              }
            },
            "color": {
              "value": "<?php echo getcolor(2); ?>"
            },
            "shape": {
              "type": "circle",
              "stroke": {
                "width": 0,
                "color": "<?php echo getcolor(2); ?>"
              },
              "polygon": {
                "nb_sides": 6
              },
              "image": {
                "src": "img/github.svg",
                "width": 100,
                "height": 100
              }
            },
            "opacity": {
              "value": 1,
              "random": true,
              "anim": {
                "enable": true,
                "speed": 2,
                "opacity_min": 0,
                "sync": true
              }
            },
            "size": {
              "value": 3,
              "random": true,
              "anim": {
                "enable": false,
                "speed": 4,
                "size_min": 0.3,
                "sync": false
              }
            },
            "line_linked": {
              "enable": false,
              "distance": 150,
              "color": "<?php echo getcolor(2); ?>",
              "opacity": 0.4,
              "width": 1
            },
            "move": {
              "enable": true,
              "speed": 1,
              "direction": "none",
              "random": true,
              "straight": false,
              "out_mode": "out",
              "bounce": true,
              "attract": {
                "enable": false,
                "rotateX": 600,
                "rotateY": 600
              }
            }
          },
          "interactivity": {
            "detect_on": "canvas",
            "events": {
              "onhover": {
                "enable": true,
                "mode": "bubble"
              },
              "onclick": {
                "enable": true,
                "mode": "repulse"
              },
              "resize": true
            },
            "modes": {
              "grab": {
                "distance": 400,
                "line_linked": {
                  "opacity": 1
                }
              },
              "bubble": {
                "distance": 250,
                "size": 0,
                "duration": 2,
                "opacity": 0,
                "speed": 3
              },
              "repulse": {
                "distance": 400,
                "duration": 0.4
              },
              "push": {
                "particles_nb": 4
              },
              "remove": {
                "particles_nb": 2
              }
            }
          },
          "retina_detect": true
        };



    particlesJS(targetid, bubbles);

  }
    particlesbg('particled', 'default');
});
</script>