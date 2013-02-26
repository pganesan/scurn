$(function() {

	startup();

	$(".ui-tabs-panel:visible").ajaxSuccess(function() {
		init();
	});
	// action for products page
	$("#scurnproducts").live("submit", function() {
		// create an AJAX call
		$.ajax({
			// validate form before ajax call;
			beforeSend : function() {
				// if this returns false, the ajax call will not be made
				return validateScurnProducts();
			},
			data : $(this).serialize(),
			type : $(this).attr("method"),
			url : $(this).attr("action"),
			success : function(response) {
				// update the tab content
				$(".ui-tabs-panel:visible").html(response);
				$("#orderError").hide();
			}
		});

		// prevent default submit
		return false;
	});
	// action for order page
	$("#scurnorder").live("submit", function() {
		// create an AJAX call
		$.ajax({
			// validate form before ajax call;
			beforeSend : function() {
				// if this returns false, the ajax call will not be made
				return validateScurnOrder();
			},
			data : $(this).serialize(),
			type : $(this).attr("method"),
			url : $(this).attr("action"),
			success : function(response) {
				// update the tab content
				$(".ui-tabs-panel:visible").html(response);
			}
		});

		// prevent default submit
		return false;
	});
	// action for quiz page
	$("#scurnquiz").live("submit", function() {
		// create an AJAX call
		$.ajax({
			// validate form before ajax call;
			beforeSend : function() {
				// if this returns false, the ajax call will not be made
				validateScurnQuiz();
			},
			data : $(this).serialize(),
			type : $(this).attr("method"),
			url : $(this).attr("action"),
			success : function(response) {
			// update the tab content
				$(".scurnInfo").html(response);
				$(".scurnInfo").dialog("option", "title", "Quiz Results");
				$(".scurnInfo").dialog("open");
			}
		});

		// prevent default submit
		return false;
	});
	$("#login").live("submit", function() {
		// create an AJAX call
		$.ajax({
			// validate form before ajax call;
			beforeSend : function() {
				// if this returns false, the ajax call will not be made
				return validateLogin();
			},
			data : $(this).serialize(),
			type : $(this).attr("method"),
			url : $(this).attr("action"),
			success : function(response) {
				$("#loginbox").html(response);
				$("#menu").tabs('load', 2);
			},
			error : function(xhr, status, error) {
				showError($("#loginError"), xhr.responseText);
			}
		});

		// prevent default submit
		return false;
	});

	$("#logout").live("submit", function() {
		// create an AJAX call
		$.ajax({
			type : $(this).attr("method"),
			url : $(this).attr("action"),
			success : function(response) {
				$("#loginbox").html(response);
				$("#signin").button("option", "label", "Sign in");
				$("#menu").tabs('load', 2);
			}
		});

		// prevent default submit
		return false;
	});

	$("#newuser").live("click", function() {
		$("#registerDialog").load("scurnregister.php");
		$("#registerDialog").dialog("open");
		return false;
	});

	$("#createcat").live("click", function() {
		$("#createCatDialog").load("create_category.php");
		$("#createCatDialog").dialog("open");
		return false;
	});
	$("#createtopic").live("click", function() {
		$("#createTopicDialog").load("create_topic.php");
		$("#createTopicDialog").dialog("open");
		return false;
	});
	$("#scurnforum a, #scurnViewCatForum a").live("click", function() {
		// create an AJAX call
		$.ajax({
			type : "get",
			url : $(this).attr("href"),
			success : function(response) {
				// update the tab content
				$(".ui-tabs-panel:visible").html(response);
			}
		});

		// prevent default submit
		return false;
	});

	$("#shareButton").live("click", function() {
		// create an AJAX call
		$.ajax({
			// validate form before ajax call;
			beforeSend : function() {
				// if this returns false, the ajax call will not be made
				if($("#reply-content").val() == "") {
					return false;
				} else {
					return true;
				}
			},
			data : $("#scurnViewTopicForum").serialize(),
			type : $("#scurnViewTopicForum").attr("method"),
			url : $("#scurnViewTopicForum").attr("action"),
			success : function(response) {
				// update the tab content
				$(".ui-tabs-panel:visible").html(response);
			}
		});

		// prevent default submit
		return false;
	});

	$(".forumBack").live("click", function() {
		$("#menu").tabs('load', 2);
		return false;
	});

	$("#googleSrch").live("click", function() {
		var f = this.form;
		f.submit();
		return false;
	});

	$("#orderCancelBtn").live("click", function() {
		$("#menu").tabs('load', 1);
		return false;
	});

	$("#myProfile").live("click", function() {
		$("#profileDialog").load("memberprofile.php");
		$("#profileDialog").dialog("open");
		return false;
	});

	$(".productsBack").live("click", function() {
		$("#menu").tabs('load', 1);
		return false;
	});
});
// things to do on document load
function startup() {
	// create tabs
	$("#menu").tabs();

	// load sign in page
	$("#signin").button({
		icons : {
			secondary : "ui-icon-triangle-1-s"
		}
	});
	$("#loginbox").load("login.php", function() {
		$("#loginButton, #newuser").button();
	});
	// click event for signin
	$("#signin").click(function() {
		$("#loginbox").slideToggle("medium");
		$("#loginError").hide();
		$("#loginbox :input").removeClass("ui-state-error");
	});

	$("#loginbox").click(function(e) {
		//e.stopPropagation();
	});

	// registration dialog
	$("#registerDialog").dialog({
		autoOpen : false,
		height : 550,
		width : 880,
		modal : true,
		buttons : {
			"Create account" : function() {
				// create an AJAX call
				$.ajax({
					// validate form before ajax call;
					beforeSend : function() {
						// if this returns false, the ajax call will not be made
						return validateRegistration($("#registerError"));
					},
					data : $("#scurnregister").serialize(),
					type : $("#scurnregister").attr("method"),
					url : $("#scurnregister").attr("action"),
					success : function(response) {
						$("#registerDialog").dialog("close");
						$(".scurnInfo").html(response);
						$(".scurnInfo").dialog("option", "title", "Member Registration");
						$(".scurnInfo").dialog("open");
					},
					error : function(xhr, status, error) {
						showError($("#registerError"), xhr.responseText);
					}
				});
			},
			Cancel : function() {
				$(this).dialog("close");
			}
		}
	});

	$(".scurnInfo").dialog({
		autoOpen : false,
		modal : true,
		height : 200,
		width : 550,
		buttons : {
			Ok : function() {
				$(this).dialog("close");
			}
		}
	});
	// create category dialog
	$("#createCatDialog").dialog({
		autoOpen : false,
		height : 350,
		width : 500,
		modal : true,
		buttons : {
			"Create Category" : function() {
				// create an AJAX call
				$.ajax({
					// validate form before ajax call;
					beforeSend : function() {
						// if this returns false, the ajax call will not be made
						return validateCreateCategory();
					},
					data : $("#createCatForm").serialize(),
					type : $("#createCatForm").attr("method"),
					url : $("#createCatForm").attr("action"),
					success : function(response) {
						$("#createCatDialog").dialog("close");
						$(".scurnInfo").html(response);
						$(".scurnInfo").dialog("option", "title", "Create Category");
						$(".scurnInfo").dialog("open");
						$("#menu").tabs('load', 2);
					},
					error : function(xhr, status, error) {
						showError($("#createCatError"), xhr.responseText);
					}
				});
			},
			Cancel : function() {
				$(this).dialog("close");
			}
		}
	});

	// create topic dialog
	$("#createTopicDialog").dialog({
		autoOpen : false,
		height : 430,
		width : 500,
		modal : true,
		buttons : {
			"Create Topic" : function() {
				// create an AJAX call
				$.ajax({
					// validate form before ajax call;
					beforeSend : function() {
						// if this returns false, the ajax call will not be made
						return validateCreateTopic();
					},
					data : $("#createTopicForm").serialize(),
					type : $("#createTopicForm").attr("method"),
					url : $("#createTopicForm").attr("action"),
					success : function(response) {
						$("#createTopicDialog").dialog("close");
						$(".scurnInfo").html(response);
						$(".scurnInfo").dialog("option", "title", "Create Topic");
						$(".scurnInfo").dialog("open");
					},
					error : function(xhr, status, error) {
						showError($("#createTopicError"), xhr.responseText);
					}
				});
			},
			Cancel : function() {
				$(this).dialog("close");
			}
		}
	});
	// registration dialog
	$("#profileDialog").dialog({
		autoOpen : false,
		height : 550,
		width : 880,
		modal : true,
		buttons : [{
			id : "editProfile",
			text : "Update",
			click : function(e) {
				// submit form with updated account details
				// create an AJAX call
				$.ajax({
					// validate form before ajax call;
					beforeSend : function() {
						// if this returns false, the ajax call will not be made
						return validateRegistration($("#profileError"));
					},
					data : $("#scurnprofile").serialize(),
					type : $("#scurnprofile").attr("method"),
					url : $("#scurnprofile").attr("action"),
					success : function(response) {
						$("#profileDialog").dialog("close");
						$(".scurnInfo").html(response);
						$(".scurnInfo").dialog("option", "title", "Member Profile Update");
						$(".scurnInfo").dialog("open");
					},
					error : function(xhr, status, error) {
						showError($("#profileError"), xhr.responseText);
					}
				});
			}
		}, {
			id : "cancel",
			text : "Cancel",
			click : function() {
				$(this).dialog("close");
			}
		}]
	});

	$("#quizLink").live("click", function() {
		var $tabs = $('#menu').tabs();
		$tabs.tabs('select', 3);
		return false;
	});

	$("#recycleMapLink").live("click", function() {
		var $tabs = $('#menu').tabs();
		$tabs.tabs('select', 4);
		return false;
	});

	$(".addCart").live("click", function() {
		var btnText = $(this).next("label").find('.ui-button-text');
		if(btnText.text() == "Add to Cart") {
			btnText.text("Remove from Cart");
		} else {
			btnText.text("Add to Cart");
		}
		return true;
	});
}

// initialize all elements on the visible form using jquery ui theme
function init() {
	$("input:submit, input:button, button").button();
	$("#loginbox").hide();
	$(".addCart").button();
}

// function to validate scurnproducts.php
// return true if validation successful, false otherwise
function validateScurnProducts() {
	var checked = $('#scurnproducts input[type="checkbox"]').is(':checked');
	if(!checked) {
		showError($("#productsError"), "You must choose atleast one product before checking out");
		return false;
	}
}

// function to validate scurnorder.php
// return true if validation successful, false otherwise
function validateScurnOrder() {
	if(isEmpty($("#shipping"))) {
		showError($("#orderError"), "Please choose the desired mode of shipping");
		return false;
	}
	if($("#shipping").val() == "blank") {
		showError($("#orderError"), "Please choose the desired mode of shipping");
		return false;
	}
	if(isEmpty($("#cNumber"))) {
		showError($("#orderError"), "Card Number is required");
		return false;
	}
	if($("#cNumber").val() != "") {
		if(!checkCardNumber($("#cNumber"))) {
			showError($("#orderError"), "Card Number is invalid. Please use the format specified");
			return false;
		} else if(isEmpty($("#cName"))) {
			showError($("#orderError"), "Card Holder's full name is required");
			return false;
		}
	}
	if(isEmpty($("#fname"))) {
		showError($("#orderError"), "First Name is required");
		return false;
	}
	if(isEmpty($("#lname"))) {
		showError($("#orderError"), "Last Name is required");
		return false;
	}
	if(isEmpty($("#addr"))) {
		showError($("#orderError"), "Address is required");
		return false;
	}
	if(isEmpty($("#city"))) {
		showError($("#orderError"), "City is required");
		return false;
	}
	if(isEmpty($("#state"))) {
		showError($("#orderError"), "State is required");
		return false;
	}
	if(isEmpty($("#zip"))) {
		showError($("#orderError"), "Zip code is required");
		return false;
	}
	if(!checkZipCode($("#zip"))) {
		showError($("#orderError"), "Zip code must contain only 5 digits");
		return false;
	}
	if(isEmpty($("#email"))) {
		showError($("#orderError"), "Email address is required");
		return false;
	}
	if(($("#phone").val() != "") && (!checkPhone($("#phone")))) {
		showError($("#orderError"), "Phone number is invalid. Please use the format specified");
		return false;
	}
}

// function to validate scurnquiz.php
// return true if validation successful, false otherwise
function validateScurnQuiz() {
	return true;
}

// validate signin
function validateLogin() {
	// if this returns false, the ajax call will not be made
	if(isEmpty($("#user"))) {
		showError($("#loginError"), "Username is required");
		return false;
	} else if(isEmpty($("#pass"))) {
		showError($("#loginError"), "Username/password is incorrect");
		return false;
	}
}

// validate fields in registration form
function validateRegistration(errorObj) {
	// if this returns false, the ajax call will not be made
	if(isEmpty($("#fname"))) {
		showError(errorObj, "First Name is required");
		return false;
	}
	if(isEmpty($("#lname"))) {
		showError(errorObj, "Last Name is required");
		return false;
	}
	if(isEmpty($("#addr"))) {
		showError(errorObj, "Address is required");
		return false;
	}
	if(isEmpty($("#city"))) {
		showError(errorObj, "City is required");
		return false;
	}
	if(isEmpty($("#state"))) {
		showError(errorObj, "State is required");
		return false;
	}
	if(isEmpty($("#zip"))) {
		showError(errorObj, "Zip code is required");
		return false;
	}
	if(isEmpty($("#email"))) {
		showError(errorObj, "Email address is required");
		return false;
	}
	if(isEmpty($("#uname"))) {
		showError(errorObj, "Please provide a username for your account");
		return false;
	}
	if(isEmpty($("#pwd"))) {
		showError(errorObj, "Please provide a password for your account");
		return false;
	}
	if(!checkZipCode($("#zip"))) {
		showError(errorObj, "Zip code must contain only 5 digits");
		return false;
	}
	if(!checkEmail($("#email"))) {
		showError(errorObj, "Email address is invalid");
		return false;
	}
	if(($("#phone").val() != "") && (!checkPhone($("#phone")))) {
		showError(errorObj, "Phone number is invalid. Please use the format specified");
		return false;
	}
	if(!checkSpecialChars($("#uname"))) {
		showError(errorObj, "User Name must start with an alphabet and can be followed by only alphabets, numbers or underscore");
		return false;
	}
	if($("#cardnum").val() != "") {
		if(!checkCardNumber($("#cardnum"))) {
			showError(errorObj, "Card Number is invalid. Please use the format specified");
			return false;
		} else if(isEmpty($("#cardHolderName"))) {
			showError(errorObj, "Card Holder's full name is required");
			return false;
		}
	}
}

// validate creation of forum categories
function validateCreateCategory() {
	if(isEmpty($("#cat_name"))) {
		showError($("#createCatError"), "Category Name is required");
		return false;
	}
	if(isEmpty($("#cat_description"))) {
		showError($("#createCatError"), "Category Description is required");
		return false;
	}
}

// validate creation of forum topics
function validateCreateTopic() {
	if(isEmpty($("#topic_subject"))) {
		showError($("#createTopicError"), "Topic subject is required");
		return false;
	}
	if(isEmpty($("#post_content"))) {
		showError($("#createTopicError"), "Please enter a message to post to the topic");
		return false;
	}
}

// update total and price of item when quantity is changed
function quantValue(value, id, price, count, isMember) {
	var quant = value;
	var price = price;
	var id = id;
	var range = count;
	var total = 0;
	var ftotal = 0;
	var discount = 0;
	var afterDiscount = 0;
	var finalTotal = 0;
	var tax = 0;

	document.getElementById("price" + id).value = (quant * price).toFixed(2);

	for(var i = 1; i <= range; i++) {
		var prev = document.getElementById("price" + i).value;
		prev = parseFloat(prev);
		total = total + prev;
	}

	var shippingSelected = $("#shipping").val();
	var sCost = parseFloat(shippingSelected);
	if(!isNaN(sCost)) {
		var total = total + sCost;
		if(isMember == 1) {
			discount = (total * 0.1);
			afterDiscount = total - discount;
			tax = (afterDiscount * 0.085);
			total = afterDiscount;
			discount = discount.toFixed(2);
			//			document.getElementById("discount").value = discount;
			$('input[name=discount]').val(discount);
		} else {
			tax = (total * 0.085);
		}
		total = parseFloat(total);
		tax = parseFloat(tax);
		ftotal = total + tax;
		ftotal = ftotal.toFixed(2);
		document.getElementById("total").value = ftotal;
		$('input[name=hiddenval]').val(ftotal);
		document.getElementById("hiddenval").value = ftotal;
	} else {
		if(isMember == 1) {
			discount = (total * 0.1);
			afterDiscount = total - discount;
			tax = afterDiscount * 0.085;
			total = afterDiscount;
			discount = discount.toFixed(2);
			//			document.getElementById("discount").value = discount;
			$('input[name=discount]').val(discount);
		} else {
			tax = (total * 0.085);
		}
		total = parseFloat(total);
		tax = parseFloat(tax);
		ftotal = total + tax;
		ftotal = ftotal.toFixed(2);
		document.getElementById("total").value = ftotal;
		$('input[name=hiddenval]').val(ftotal);
		document.getElementById("hiddenval").value = ftotal;
	}
	tax = tax.toFixed(2);
	//	document.getElementById("tax").value = tax;
	$('input[name=tax]').val(tax);
}

// update total price of order when shipping method is chosen
function shippingChanged(count, isMember) {
	var discount = 0;
	var afterDiscount = 0;
	var finalTotal = 0;
	var tax = 0;
	var ftotal = 0;

	var shippingSelected = $("#shipping").val();

	if(shippingSelected == "blank") {
		var total = 0;
		for(var i = 1; i <= count; i++) {
			var prev = document.getElementById("price" + i).value;
			prev = parseFloat(prev);
			total = total + prev;
			total = total.toFixed(2);
		}
		if(isMember == 1) {
			discount = (total * 0.1);
			afterDiscount = total - discount;
			tax = (afterDiscount * 0.085);
			total = afterDiscount;
			discount = discount.toFixed(2);
			//			document.getElementById("discount").value = discount;
			$('input[name=discount]').val(discount);
		} else {
			tax = (total * 0.085);
		}
		total = parseFloat(total);
		tax = parseFloat(tax);
		ftotal = total + tax;
		ftotal = ftotal.toFixed(2);
		document.getElementById("total").value = ftotal;
		$('input[name=hiddenval]').val(ftotal);
		document.getElementById("hiddenval").value = ftotal;
		tax = tax.toFixed(2);
		//		document.getElementById("tax").value = tax;
		$('input[name=tax]').val(tax);
	} else {
		var sCost = parseFloat(shippingSelected);
		var total = 0;
		for(var i = 1; i <= count; i++) {
			var prev = document.getElementById("price" + i).value;
			prev = parseFloat(prev);
			total = total + prev;
		}
		var total = (total + sCost);

		if(isMember == 1) {
			discount = (total * 0.1);
			afterDiscount = total - discount;
			tax = (afterDiscount * 0.085);
			total = afterDiscount;
			discount = discount.toFixed(2);
			//			document.getElementById("discount").value = discount;
			$('input[name=discount]').val(discount);
		} else {
			tax = (total * 0.085);
		}
		tax = tax.toFixed(2);
		document.getElementById("tax").value = tax;
		total = parseFloat(total);
		tax = parseFloat(tax);
		ftotal = total + tax;
		ftotal = ftotal.toFixed(2);
		document.getElementById("total").value = ftotal;
		$('input[name=hiddenval]').val(ftotal);
		document.getElementById("hiddenval").value = ftotal;
		switch (sCost) {
			case 4.99:
				$('input[name=shipcode]').val("1");
				break;
			case 7.99:
				$('input[name=shipcode]').val("2");
				break;
			case 9.99:
				$('input[name=shipcode]').val("3");
				break;
		}
	}
}