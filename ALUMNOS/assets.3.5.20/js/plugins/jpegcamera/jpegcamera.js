$(function() {
  if (window.JpegCamera) {
    var camera; // Initialized at the end

    var update_stream_stats = function(stats) {
      $("#stream_stats").html(
        "Iluminaci&oacute;n = " + stats.mean +
        "; Desviaci&oacute;n Standard = " + stats.std);

      setTimeout(function() {camera.get_stats(update_stream_stats);}, 1000);
    };

    var take_snapshots = function(count) {
      var snapshot = camera.capture();

      if (JpegCamera.canvas_supported()) {
        snapshot.get_canvas(add_snapshot);
      }
      else {
        // <canvas> is not supported in this browser. We'll use anonymous
        // graphic instead.
        var image = document.createElement("img");
        image.src = "no_canvas_photo.jpg";
        setTimeout(function() { add_snapshot.call(snapshot, image); }, 1);
      }

      if (count > 1) {
        setTimeout(function() {take_snapshots(count - 1);}, 500);
      }
    };

    var add_snapshot = function(element) {
      $(element).data("snapshot", this).addClass("item");

      var $container = $("#snapshots").append(element);
      var $camera = $("#camera");
      var camera_ratio = $camera.innerWidth() / $camera.innerHeight();

      var height = $container.height();
      element.style.height = "" + height + "px";
      element.style.width = "" + Math.round(camera_ratio * height) + "px";

      var scroll = $container[0].scrollWidth - $container.innerWidth();

      $container.animate({
        scrollLeft: scroll
      }, 200);
    };

    var select_snapshot = function () {
      $(".item").removeClass("selected");
      var snapshot = $(this).addClass("selected").data("snapshot");
      snapshot.show();
      //$("#show_stream").show();
      //$("#discard_snapshot, #upload_snapshot, #api_url").show();
      //display
      document.getElementById("discard_snapshot").style.display = "inline-block";
      document.getElementById("upload_snapshot").style.display = "inline-block";
      document.getElementById("show_stream").style.display = "inline-block";
      //clases
      $("#discard_snapshot").addClass("btn btn-danger");
      $("#upload_snapshot").addClass("btn btn-success");
      $("#show_stream").addClass("btn btn-default");
    };

    var clear_upload_data = function() {
      $("#upload_status, #upload_result").html("");
    };

    var upload_snapshot = function() {
      var api_url = $("#api_url").val();

      if (!api_url.length) {
        $("#upload_status").html("Please provide URL for the upload");
        return;
      }

      clear_upload_data();
      $("#loader").show();
      $("#upload_snapshot").prop("disabled", true);

      //--
      cui = document.getElementById("cui").value;
      canvas = document.getElementsByClassName('item selected');
      abrir();
			var dataurl = canvas[0].toDataURL("image/jpeg", 1.0);
      var blob = dataURLtoBlob(dataurl);
			var f1 = new FormData();
      f1.append("cui", cui);
			f1.append("imagen", blob);
			var request = new XMLHttpRequest();
			request.open("POST", "EXEeditfoto.php");
			request.send(f1);
			
			window.setTimeout(redirige,1000);
      
    };

    var upload_done = function(response) {
      $("#upload_snapshot").prop("disabled", false);
      $("#loader").hide();
      $("#upload_status").html("Upload successful");
      $("#upload_result").html(response);
    };

    var upload_fail = function(code, error, response) {
      $("#upload_snapshot").prop("disabled", false);
      $("#loader").hide();
      $("#upload_status").html(
        "Upload failed with status " + code + " (" + error + ")");
      $("#upload_result").html(response);
    };

    var discard_snapshot = function() {
      var element = $(".item.selected").removeClass("item selected");

      /*var next = element.nextAll(".item").first();
      if (!next.size()) {
        next = element.prevAll(".item").first();
      }
      if (next.size()) {
        next.addClass("selected");
        next.data("snapshot").show();
      }else {
        hide_snapshot_controls();
      }*/

      element.data("snapshot").discard();

      element.hide("slow", function() { $(this).remove(); });
    };

    var show_stream = function() {
      $(this).hide();
      $(".item").removeClass("selected");
      hide_snapshot_controls();
      clear_upload_data();
      camera.show_stream();
    };

    var hide_snapshot_controls = function() {
      $("#discard_snapshot, #upload_snapshot, #api_url").hide();
      $("#upload_result, #upload_status").html("");
      $("#show_stream").hide();
    };

    $("#take_snapshots").click(function() {take_snapshots(1);});
    $("#snapshots").on("click", ".item", select_snapshot);
    $("#upload_snapshot").click(upload_snapshot);
    $("#discard_snapshot").click(discard_snapshot);
    $("#show_stream").click(show_stream);

    var options = {
      shutter_ogg_url: "shutter.ogg",
      shutter_mp3_url: "shutter.mp3",
      swf_url: "jpeg_camera.swf"
    };

    camera = new JpegCamera("#camera", options).ready(function(info) {
      $("#take_snapshots").show();

      $("#camera_info").html(
        "Resoluci&oacute;n de la Camara: " + info.video_width + "x" + info.video_height);

      this.get_stats(update_stream_stats);
    });
  }
});



    function dataURLtoBlob(dataurl) {
				var arr = dataurl.split(','), mime = arr[0].match(/:(.*?);/)[1],
					bstr = atob(arr[1]), n = bstr.length, u8arr = new Uint8Array(n);
				while(n--){
					u8arr[n] = bstr.charCodeAt(n);
				}
				return new Blob([u8arr], {type:mime});
		}
			
		function redirige(){
			cerrar();
      hashkey = document.getElementById("hashkey").value;
      window.location.href = "FRMeditfoto.php?hashkey="+hashkey;
		}
