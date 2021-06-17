jQuery(document).ready(function() {
	$('body').prepend('<div class="header" id="myHeader"><h2>Thank you for reading WeeklyHow\'s Tutorial!</h2></div>');
	$('head').prepend('<style>.header { padding: 10px 16px; background: #555; color: #f1f1f1; } .content { padding: 16px; } .sticky { position: fixed; top: 0; width: 100%} .sticky + .content { padding-top: 102px; }</style>');

	var header = document.getElementById("myHeader");
	var sticky = header.offsetTop;

	window.onscroll = function() {
		if (window.pageYOffset > sticky) {
			header.classList.add("sticky");
		} else {
			header.classList.remove("sticky");
		}
	};

});
