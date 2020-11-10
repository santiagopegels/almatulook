<script src="https://cdnjs.cloudflare.com/ajax/libs/validator/13.1.0/validator.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/localization/messages_es.min.js"></script>

<script>
	$(function() {
		'use strict';

		/**
		 *Variables paths
		 */
		var isUsers = "{{ Request::is('*users*') }}";

		/**
		 * Variables create 
		 */
		var isUsersCreate = "{{ Request::is('*users/create') }}";

		/**
		 * Variable isEdit path
		 */
		var isEdit = "{{ Request::is('*edit') }}";
		//console.log('isEdit', isEdit);

		const minlength = 3;
		const maxlength = 255;

		/**
		 * Exec by defaults
		 */

		setDefaults();

		if (isUsers) {
			console.log('validateUser', isUsers);
			validateUser();
		}


		function setDefaults() {

			$.validator.setDefaults({
				onfocusout: function(e) {
					this.element(e);
				},
				onkeyup: false,

				highlight: function(element) {
					jQuery(element).closest('.form-control').addClass('is-invalid');
				},
				unhighlight: function(element) {
					jQuery(element).closest('.form-control').removeClass('is-invalid');
					jQuery(element).closest('.form-control').addClass('is-valid');
				},

				errorElement: 'div',
				errorClass: 'invalid-feedback',
				errorPlacement: function(error, element) {
					if (element.parent('.input-group-prepend').length) {
						$(element).siblings(".invalid-feedback").append(error);
						//error.insertAfter(element.parent());
					} else {
						error.insertAfter(element);
					}
				},
			});
		}

		/**
		 * Forms validator
		 */

		function validateUser() {
			var validate_user = $("#validate_user");
			validate_user.submit(function(e) {
				e.preventDefault();
			}).validate({
				onkeyup: false,
				focusCleanup: false,
				onsubmit: true,
				lang: 'es',
				ignore: ':hidden:not([class~=selectized]),:hidden > .selectized, .selectize-control .selectize-input input',
				rules: {
					name: {
						required: true,
						minlength: minlength,
						maxlength: maxlength
					},
					password: {
						required: true,
						minlength: minlength,
						maxlength: maxlength
					},
					password_confirmation: {
						required: true,
						minlength: minlength,
						maxlength: maxlength,
						equalTo: "#password"
					},

				},
				messages: {
					name: {
						required: "Por favor proporcione el nombre.",
						minlength: `El nombre debe tener al menos ${minlength} caracteres.`,
						maxlength: `El nombre debe tener como máximo ${maxlength} caracteres.`
					},
					password: {
						required: "Por favor proporcione una contraseña.",
						minlength: `La contraseña debe tener al menos ${minlength} caracteres.`,
						maxlength: `La contraseña debe tener como máximo ${maxlength} caracteres.`
					},
					password_confirmation: {
						required: "Por favor proporcione una contraseña.",
						minlength: `La contraseña debe tener al menos ${minlength} caracteres.`,
						maxlength: `La contraseña debe tener como máximo ${maxlength} caracteres.`,
						equalTo: "Por favor ingrese la misma contraseña que arriba."
					},
				},
				submitHandler: function(form) {
					console.log('submitHandler');
					form.submit();
				}
			});
		}

	});
</script>