$(document).ready(function(){
    $(".afreg_radio").after("<br/>")
    $(".email_conts").insertBefore("#billing_country_field")
    $(".confirm-pass").insertAfter(".email_conts")

    let htmlFooter = `
        <div class='reg-footer-text'>
        <strong>Program Details</strong> By registering, you acknowledge that you are over 18 years of
        age and live in the United States. There is no charge for product(s) or shipping. We
        simply ask that for each shipment, you complete the online survey in order to
        remain active. You allow us and our clients to use your opinions, feedback and
        reviews for use in product development, marketing materials and advertisements.
        We agree to keep your personal information confidential.
        </div>
    `
    $(".afreg_extra_fields").after(htmlFooter)

    $(".woocommerce-form-register").prepend("<h5 class='create-acc'>Create Log-In Information<h5>")
})