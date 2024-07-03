/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import "./styles/app.scss";
import "./styles/custom.scss";
import './toast';

require("bootstrap");
// start the Stimulus application
import "./bootstrap";
require("font-awesome/css/font-awesome.css");

document.ready(
  $("#piece_type").on("change", function () {
    console.log("Hello");
    if ($(this).val() == "Livrable") {
      $("#piece_gamme").show();
      $("#piece_gamme").attr("data-error", "This field is required.");
    } else {
      $("#piece_gamme").hide();
      $("#piece_gamme").removeAttr("required");
      $("#piece_gamme").removeAttr("data-error");
    }
  })
);
