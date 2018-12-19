<?php
//////////////////////////////////////////////////////////////
// 							RetroCMS 						//
//<<<<<<<<<<<<<< The Oldschool Era is Back >>>>>>>>>>>>>>>>>//
//----------------------------------------------------------//
// Developed by: Marcos ( M.tiago )							//
//////////////////////////////////////////////////////////////
// Alpha Version 0.7.0 ( Opal ) 							//
// Branch: Public											//
//////////////////////////////////////////////////////////////
?>

<?php 
//Include Header Content
include('./Web/Includes/Content/Headers/Register.php'); 

//Page Content >>
?>


<div id="outer">
<div id="outer-content">
<div class="processbox">
	<div class="headline">
		<div class="headline-content">
			<div class="headline-wrapper">
				<h2>Registration <a href="<?php echo $this->hotel->get_HotelURL(); ?>/register/exit" class="exit">Cancel</a></h2>
			</div>
		</div>
	</div>
	<div class="content-top">
		<div class="content">
			<div class="content-column1">
				<div class="bubble">
					<div class="bubble-body">               
						Now to pick your habbo name and password. A good password should contain numbers and both UPPER and lowercase letters.
						<div class="clear"></div>
					</div>
				</div>
			<div class="bubble-bottom">
				<div class="bubble-bottom-body">
					<img src="<?php echo $this->hotel->get_HotelURL() ?>/habboweb/16/11/web-gallery/images/register/bubble_tail_left.gif" alt="" width="22" height="31">
				</div>
			</div>
			<div class="frank"><img src="<?php echo $this->hotel->get_HotelURL() ?>/habboweb/16/11/web-gallery/images/register/register2.gif" alt="" width="245" height="191"></div>
		</div>
	
			<div class="content-column2">
				<div id="process-errors">
					<div class="content-red">
						<div class="content-red-body" id="process-errors-content">
							<div class="clear"></div>
						</div>
					</div>
					<div class="content-red-bottom">
						<div class="content-red-bottom-body"></div>
					</div>
				</div>
				<div class="content-white-outer">
					<div class="content-white">
						<div class="content-white-body">
							<div class="content-white-content">                                                
								<form method="post" action="<?php echo $this->hotel->get_HotelURL() ?>/register/step/3" id="stepform">                                                    
									<p>                                                        
										<b>CHOOSE YOUR USERNAME:</b>
										<br>
										Your <b>username</b> can contain lowercase and uppercase letters. Your username can also contain numbers and the following characters: -=?!@:.                                                    
									</p> 
									
									<p>                                                        
										<label for="required-avatarName" class="registration-text">Username</label>
										<br>                                                        
										<input type="text" name="required-avatarName" id="username" maxlength="14" value="" class="registration-text required-avatarName">                                                    
									</p> 
									
									<hr> 
									
									<p>                                                        
										<b>NOW, CHOOSE YOUR PASSWORD:</b>
										<br
										>Your <b>password</b> must be at least six characters long. Your <b>password</b> can contain both <b>uppercase letters</b> and <b>numbers</b>. 
									</p> 
									
									<p>                                                        
										<label for="required-password" class="registration-text">Password</label><br>                                                        
										<input type="password" name="required-password" id="password" maxlength="32" value="" class="registration-text required-password required-password2">                                                    
									</p>  
									
									<div id="pwStatus"></div>                                                    
									
									<p>                                                       
										<label for="required-password" class="registration-text">Retype password</label><br>                                                        
										<input type="password" name="required-password" id="retypedPassword" maxlength="32" value="" class="registration-text required-retypedPassword required-retypedPassword2">                                                    
									</p>   
								
									<div id="pwRetypeStatus"></div>                                                    
									<div id="register-buttons">
	
									<div align="right" "="">
									<input type="submit" value="Back" id="continuebtn" class="process-button">
										<input type="hidden" name="required-birth" value="<?php echo $this->newHabbo->get_HabboBirth() ?>" />
										<input type="hidden" name="newGender" value="<?php echo $this->newHabbo->get_HabboGender() ?>" />
										<input type="hidden" name="figureData" value="<?php echo $this->newHabbo->get_HabboFigure() ?>" />
										<input type="submit" value="Continue" id="continuebtn" class="process-button">
									</div>
									<div class="clear"></div>                                                    
									</div>                                                
								</form>                                            
							</div>
									<div class="clear"></div>
								</div>
							</div>
							<div class="content-white-bottom">
								<div class="content-white-bottom-body"></div>
							</div>
						</div>
					</div>
				<div class="clear"></div>
			</div>
		</div>
		<div class="content-bottom"><div class="content-bottom-content"></div></div>
	</div>

	<script type="text/javascript">
	$(document).ready(function() {
		var x_timer;    
		$("#username").keyup(function (e){
			clearTimeout(x_timer);
			var user_name = $(this).val();
			x_timer = setTimeout(function(){
				check_username_ajax(user_name);
			}, 1000);
		}); 

	function check_username_ajax(username){
		$("#user-result").php('<img src="ajax-loader.gif" />');
		$.post('http://localhost/username-checker.php', {'username':username}, function(data) {
		  $("#user-result").php(data);
		});
	}
	});
	</script>

	<script type="text/javascript" language="JavaScript">
	function initUserDetailForm() {
		Object.extend(Validation, { addError : validatorAddError });
		Validation.addAllThese([
			['required-avatarName', 'Please choose your name', function(v) {
				return !Validation.get('IsEmpty').test(v);
			}],
			['required-password', 'Please enter a password', function(v) {
				return !Validation.get('IsEmpty').test(v);
			}],
			['required-password2', 'Password is too short', function(v) {
				return v.length >= 6;
			}],
			['required-retypedPassword', 'Please type your password again', function(v) {
				return !Validation.get('IsEmpty').test(v);
			}],
			['required-retypedPassword2', 'The passwords you typed are not identical', function(v) {
				return v == $F("password");
			}]
		]);
		new Validation('stepform', {focusOnError:true, beforeSubmit:validatorBeforeSubmit, skipValidation:function(){ return backClicked; }});
		
		initPasswordCheck();
	}
	function initPasswordCheck() {
		updatePasswordStatus(false, true);
		
		new Form.Element.Observer(
			"password", .7, 
			function(element, value) {
				updatePasswordStatus(false, false);
			}
		);
		
		new Form.Element.Observer(
			"retypedPassword", .3, 
			function(element, value) {
				updatePasswordStatus(false, false);
			}
		);
	}
	function updatePasswordStatus(remoteCheck, init) {
		var value = $F("password");
		
		if (!init) {
			if (!value || value.length < 6) {
				showPasswordLengthMsg("Your password must be at least 6 characters long.", "error");
				pwTotal[0] = false;
			} else {
				showPasswordLengthMsg("Password is securely long enough.", "ok");
				pwTotal[0] = true;
			}
		}
		
		if (value.length < 6) {
			if ($("pwChars")) { Element.remove("pwChars"); }
			pwTotal[1] = false;
		} else if (remoteCheck) {
			new Ajax.Request(
				habboReqPath + "register/password", {
					method: "get",
					parameters: "password=" + encodeURIComponent(value), 
					onComplete: showPasswordStatus
				}
			);
		}
		
		if (!init) {
			var retyped = $F("retypedPassword");
			if (!retyped) {
				if ($("pwMatch")) {
					showStatusMsg("pwMatch", "To make sure you didn\'t misspell, Please retype your password below.", "error");
				}
				pwTotal[2] = false;
			} else if (retyped == $F("password")) {
				showPasswordMatchMsg("The two passwords match.", "ok");
				pwTotal[2] = true;
				Element.removeClassName($("retypedPassword"), "validation-failed");
			} else {
				showPasswordMatchMsg("Passwords don\'t match.", "error");
				pwTotal[2] = false;
			}
			
			updatePasswordTotal();
		}
	}
	function showPasswordLengthMsg(msg, status) {
		var msgNode = $("pwLength");
		if (!msgNode) {
			var node = Builder.node("div", { id:"pwLength", className:"field-status-error" }, [
				Builder.node("b", "Length check: "), 
				Builder.node("span", { id:"pwLength-content" })
			]);
			var charsNode = $("pwChars");
			if (!charsNode) {
				$("pwStatus").appendChild(node);
			} else {
				$("pwStatus").insertBefore(node, $("pwChars"));
			}
		}
		
		showStatusMsg("pwLength", msg, status);
	}
	function showPasswordCharsMsg(msg, status) {
		var msgNode = $("pwChars");
		if (!msgNode) {
			var node = Builder.node("div", { id:"pwChars", className:"field-status-error" }, [
				Builder.node("b", "Character check: "), 
				Builder.node("span", { id:"pwChars-content" })
			]);
			$("pwStatus").appendChild(node);
		}
		
		showStatusMsg("pwChars", msg, status);
	}
	function showPasswordMatchMsg(msg, status) {
		var msgNode = $("pwMatch");
		if (!msgNode) {
			var node = Builder.node("div", { id:"pwMatch", className:"field-status-error" }, [
				Builder.node("b", "Match check: "), 
				Builder.node("span", { id:"pwMatch-content" })
			]);
			$("pwRetypeStatus").insertBefore(node, $("pwTotal"));
		}
		
		showStatusMsg("pwMatch", msg, status);
	}
	function updatePasswordTotal() {
		var msgNode = $("pwTotal");
		if (!msgNode) {
			msgNode = $("pwRetypeStatus").appendChild(Builder.node("div", {id:"pwTotal"}));
		}
		
		if (pwTotal[0] && pwTotal[1] && pwTotal[2]) {
			msgNode.innerHTML = "Your password is secure!";
		} else {
			msgNode.innerHTML = "Please check your password is long enough, contains all required characters and is rewritten correctly.";
		}
	}
	function showPasswordStatus(req, jsonObj) {
		if (jsonObj.charOk) {
			showPasswordCharsMsg(jsonObj.charOk, "ok");
			pwTotal[1] = true;
		} else {
			showPasswordCharsMsg(jsonObj.charErr || "You must use lowercase letters, uppercase letters and numbers.", "error");
			pwTotal[1] = false;
		}
		updatePasswordTotal();
	}
	initUserDetailForm();
	</script>

<?php 

//<< Page Content

//Include Footer Content
include('./Web/Includes/Content/Footers/Process.php'); 

?>