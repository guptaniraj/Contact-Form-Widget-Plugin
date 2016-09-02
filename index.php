<?php
/*
Plugin Name: N Contact Form Widget Plugin
Description: N Contact Form Widget Plugin
Version: 1.1
Author: Niraj Gupta
*/

class ncontactformwidget_plugin extends WP_Widget
{
	// constructor
    function ncontactformwidget_plugin() 
	{
        parent::WP_Widget(false, $name = __('N Contact Form Widget', 'wp_widget_plugin') );
    }

	// widget form creation
	function form($instance)
	{
		// Check values
		if( $instance)
		{
			$title = esc_attr($instance['title']);	
			$to = esc_attr($instance['to']);	
			$from = esc_attr($instance['from']);
			$subject = esc_attr($instance['subject']);
			$body = esc_attr($instance['body']);			 
			$req_msg = esc_attr($instance['req_msg']);
			$sub_msg = esc_attr($instance['sub_msg']);
		} 
		else
		{
			$title = '';
			$to = '';
			$from = '';
			$subject = '';
			$body = '';			 
			$req_msg = '';
			$sub_msg = '';
		}	?>
		
		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Form Name', 'wp_widget_plugin'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		
		
		<p>
		<label for="<?php echo $this->get_field_id('to'); ?>"><?php _e('Mail To', 'wp_widget_plugin'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('to'); ?>" name="<?php echo $this->get_field_name('to'); ?>" type="text" value="<?php echo $to; ?>" />
		</p>
		
		
		<p>
		<label for="<?php echo $this->get_field_id('from'); ?>"><?php _e('Mail From', 'wp_widget_plugin'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('from'); ?>" name="<?php echo $this->get_field_name('from'); ?>" type="text" value="<?php echo $from; ?>" />
		</p>
		
		
		<p>
		<label for="<?php echo $this->get_field_id('subject'); ?>"><?php _e('Subject', 'wp_widget_plugin'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('subject'); ?>" name="<?php echo $this->get_field_name('subject'); ?>" type="text" value="<?php echo $subject; ?>" />
		</p>
		
		
		<p>
		<label for="<?php echo $this->get_field_id('body'); ?>"><?php _e('Message', 'wp_widget_plugin'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('body'); ?>" name="<?php echo $this->get_field_name('body'); ?>" type="text" value="<?php echo $body; ?>" />
		</p>
		
	
		<p>
		<label for="<?php echo $this->get_field_id('req_msg'); ?>"><?php _e('Message for required fields', 'wp_widget_plugin'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('req_msg'); ?>" name="<?php echo $this->get_field_name('req_msg'); ?>" type="text" value="<?php echo $req_msg; ?>" />
		</p>

		
		<p>
		<label for="<?php echo $this->get_field_id('sub_msg'); ?>"><?php _e('Message after form submission', 'wp_widget_plugin'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('sub_msg'); ?>" name="<?php echo $this->get_field_name('sub_msg'); ?>" type="text" value="<?php echo $sub_msg; ?>" />
		</p><?php
	} 	
	
	// update widget
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		// Fields
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['to'] = strip_tags($new_instance['to']);
		$instance['from'] = strip_tags($new_instance['from']);
		$instance['subject'] = strip_tags($new_instance['subject']);
		$instance['body'] = strip_tags($new_instance['body']);		
		$instance['req_msg'] = strip_tags($new_instance['req_msg']);
		$instance['sub_msg'] = strip_tags($new_instance['sub_msg']);
		return $instance;
	}
	
	// display widget
	function widget($args, $instance)
	{
		extract( $args );
		// these are the widget options
		
		$title = $instance['title'];	
		$to = $instance['to'];	
		$from = $instance['from'];
		$subject = $instance['subject'];
		$body = $instance['body'];	
		$req_msg = apply_filters('widget_title', $instance['req_msg']);
		$sub_msg = $instance['sub_msg'];
			
		echo $before_widget;

		$ajax_file = plugins_url( '', __FILE__ ).'/getvalue.php/';?>
			
		<p>
		<label for="title"><?php echo '<h2>'.$title.'</h2>';?></label>
		</p>
			
		<p>
		<label for="email">Email*</label>
		<input class="emailwidefat" id="email" name="email" type="email"/>
		</p>

		<p>
		<label for="message">Message*</label>
		<input class="messagewidefat" id="message" name="message" type="text"/>
		</p>
			
		<p>		
		<input type="hidden" id="to" name="to" value="<?php echo $to;?>" />
		<input type="hidden" id="from" name="from" value="<?php echo $from;?>" />
		<input type="hidden" id="subject" name="subject" value="<?php echo $subject;?>" />
		<input type="hidden" id="body" name="body" value="<?php echo $body;?>" />		
		<input type="hidden" id="req_msg" name="req_msg" value="<?php echo $req_msg;?>" />
		<input type="hidden" id="sub_msg" name="sub_msg" value="<?php echo $sub_msg;?>"/>
		<input type="hidden" id="ajax_file" name="ajax_file" value="<?php echo $ajax_file;?>"/>
		</p>
			
		<div class="row contact_msg">
			<div class="col-lg-6 col-lg-offset-3" id="status_error"></div>
			<div class="col-lg-6 col-lg-offset-3" id="status_result"></div>
		</div>
		
		<button type="submit" name="submit" onclick="ajax_post();" class="submitwidefat">Submit</button>

		<script>
		function ajax_post()
		{
			var hr = new XMLHttpRequest();

			var email = document.getElementById("email").value;
			var message = document.getElementById("message").value;

			var to = document.getElementById("to").value;
			var fromm = document.getElementById("from").value;
			var subject = document.getElementById("subject").value;
			var body = document.getElementById("body").value;	
			var req_msg = document.getElementById("req_msg").value;
			var sub_msg = document.getElementById("sub_msg").value;
			var ajax_file = document.getElementById("ajax_file").value;

			var url = ajax_file;
			
				
			if(to =='')
			{
				var to ='guptaniraj.gupta@gmail.com';
			}
			else{
			var to = to;	
			}
			
			if(fromm =='')
			{
				var fromm ='guptaniraj.gupta@gmail.com';
			}
			else{
			var fromm = fromm;	
			}
			
			if(subject =='')
			{
				var subject ='New query';
			}
			else{
			var subject = subject;	
			}
			
			if(body =='')
			{
				var body ='New query coming form ' + email + '  ' ;
			}
			else{
			var body = 	body;	
			}

			if(req_msg =='')
			{
				var req_msg ='Please enter required fields';
			}
			else{
			var req_msg = 	req_msg;	
			}

			if(sub_msg =='')
			{
				var sub_msg ='Thanks. We will contact you within 24 hours.';
			}
			else{
			var sub_msg = 	sub_msg;	
			}

			var tomatch= /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

			if(email =='' || message =='' )
			{
				document.getElementById("status_result").style.display = "none";
				document.getElementById("status_error").style.display = "block";
				document.getElementById("status_error").innerHTML = '<div class="error">' + req_msg + '</div> ';

			}
			else if(!tomatch.test(email))
			{
				document.getElementById("status_result").style.display = "none";
				document.getElementById("status_error").style.display = "block";
				document.getElementById("status_error").innerHTML = '<div class="error">Please enter a valid email</div>';
			}
			else
			{
				var vars = "email=" + email + "&message=" + message + "&to=" + to + "&fromm=" + fromm + "&subject=" + subject + "&body=" + body + "&sub_msg=" + sub_msg;
			
				hr.open("POST", url, true);
				hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				hr.onreadystatechange = function()
				{
					if(hr.readyState == 4 && hr.status == 200)
					{
						var return_data = hr.responseText;
						
						document.getElementById("status_error").style.display = "none";
						document.getElementById("status_result").style.display = "block";
						document.getElementById("status_result").innerHTML = return_data;
					}
				}
				hr.send(vars); 
			
				document.getElementById("status_error").style.display = "none";
				document.getElementById("status_result").style.display = "block";
				document.getElementById("status_result").innerHTML = "<h2></h2>";
				document.getElementById("email").value = "";
				document.getElementById("message").value = "";
			}
		}
		</script><?php	echo $after_widget;
	}
}
add_action('widgets_init', create_function('', 'return register_widget("ncontactformwidget_plugin");'));