(function () {
	"use strict";

	function maximizeWindow() {
		const element = document.querySelector("#wrapper");

		element
			.requestFullscreen()
			.then(function () {
				if (!$("#accordionSidebar").hasClass("toggled")) {
					$("#sidebarToggle").trigger("click");
				}
			})
			.catch(function (error) {
				// element could not enter fullscreen mode
				// error message
				console.log(error.message);
			});
	}

	function minimizeWindow() {
		document
			.exitFullscreen()
			.then(function () {
				if ($("#accordionSidebar").hasClass("toggled")) {
					$("#sidebarToggle").trigger("click");
				}
			})
			.catch(function (error) {
				// element could not exit fullscreen mode
				// error message
				console.log(error.message);
			});
	}

	$(function () {
		var request;
		$("#alterarSenha").on("click", function (evt) {
			evt.preventDefault();

			if (request) {
				request.abort();
			}
			var form = $(this);
			var inputs = form.find("input, select, button, textarea");
			var serializedData = $("#form_alterarsenha").serialize();
			inputs.prop("disabled", true);
			var url = $("#passwordChangeUrl").val();

			request = $.ajax({
				method: "POST",
				url,
				data: serializedData,
			});
			request.done(function (response, textStatus, jqXHR) {
				if (response.search("ERRO:") >= 0) {
					swal.fire("", response, "error");
				} else {
					$("#trocarsenha").modal("hide");
					$("#senhaAtual").val("");
					$("#senhaNova").val("");
					$("#senhaConfirmacao").val("");
					swal.fire("", response, "success");
				}
			});
		});

		// window: maximize / minimize
		$("#toggleMinMaxScreen").on("click", function toggleMinMaxcreen() {
			const MAX_ICON = "fa-window-maximize";
			const MIN_ICON = "fa-window-minimize";
			const icon = $("#minMaxScreenIcon");
			const isMax = () => icon.hasClass(MAX_ICON);
			const isMin = () => icon.hasClass(MIN_ICON);
			const removeAndAddClass = (remove, add) => {
				icon.removeClass(remove);
				icon.addClass(add);
			};

			if (isMax()) {
				removeAndAddClass(MAX_ICON, MIN_ICON);
				maximizeWindow();
			} else if (isMin()) {
				removeAndAddClass(MIN_ICON, MAX_ICON);
				minimizeWindow();
			}
		});

		// PAGE LOADING ANIMATION FADE-IN, FADE-OUT
		$(".theme-loader").animate({ opacity: "0" }, 1000);
		setTimeout(function () {
			$(".theme-loader").remove();
		}, 800);
	});
})();
