//Keep radio button selection after refresh if there's errors in form input data

var formValues = JSON.parse(localStorage.getItem('formValues')) || {};
var $checkboxes = $(".matrix :radio");
var $button = $("#form_container a");

// function allChecked(){
//   return $checkboxes.length === $checkboxes.filter(":checked").length;
// }

// function updateButtonStatus(){
//   $button.text(allChecked()? "Uncheck all" : "Check all");
// }

// function handleButtonClick(){
//   $checkboxes.prop("checked", allChecked()? false : true)
// }

	function updateStorage(){
	$checkboxes.each(function(){
  	formValues[this.id] = this.checked;
	 });

// formValues["buttonText"] = $button.text();
localStorage.setItem("formValues", JSON.stringify(formValues));
	}

	function clearStorage(){
	localStorage.clear();
	}

	$button.on("click", function() {
	 	clearStorage();
	});

	$checkboxes.on("change", function(){
	// updateButtonStatus();
	updateStorage();
	});

	// On page load
	$.each(formValues, function(key, value) {
	$("#" + key).prop('checked', value);
	});

	// $button.text(formValues["buttonText"]);
