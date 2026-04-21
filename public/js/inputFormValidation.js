
// Validation functions
    function validateName(id) {
        const commInput = document.getElementById(id);
    
        commInput.value = commInput.value.replace(/\s{2,}/g, ' ');
    
        commInput.value = commInput.value.replace(/[^a-zA-Z\s]/g, '');
    
        commInput.value = commInput.value.replace(/\b\w/g, function (char) {
            return char.toUpperCase();
        });
    
        const newpassmsg = $('form [id="' + id + '"]');
    
        if (commInput.value === '') {
            newpassmsg.parent().find('.help-block.text-danger').remove();
            newpassmsg.parent().find('.invalid-feedback').remove();
            newpassmsg.after('<span class="help-block text-danger" style="display:block">Field is required.</span>');
    
        } else {
            newpassmsg.parent().find('.help-block.text-danger').remove();
            newpassmsg.parent().find('.invalid-feedback').remove();
        }
    }

    function validateEmail(id) {
        const commInput = document.getElementById(id);
        const newpassmsg = $('form [id="' + id + '"]');
    
        if (commInput.value === '') {
            newpassmsg.after('<span class="help-block text-danger" style="display:block">Email field is required.</span>');
    
        } else {
            newpassmsg.parent().find('.help-block.text-danger').remove();
        }
    }
    
    function validatePhone(id) {
        const commInput = document.getElementById(id);
    
        commInput.value = commInput.value.replace(/[^\d]/g, '');
    
        commInput.value = commInput.value.replace(/[^0-9\s]/g, '');
    
        const newpassmsg = $('form [id="' + id + '"]');
    
        if (commInput.value === '') {
            newpassmsg.parent().find('.help-block.text-danger').remove();
            newpassmsg.after('<span class="help-block text-danger" style="display:block">Field is required.</span>');
        } else {
            newpassmsg.parent().find('.help-block.text-danger').remove();
        }
    }
    function validatePinCode(id) {
        const commInput = document.getElementById(id);
    
        commInput.value = commInput.value.replace(/[^\d]/g, '');
    
        commInput.value = commInput.value.replace(/[^0-9\s]/g, '');
    
        const newpassmsg = $('form [id="' + id + '"]');
    
        if (commInput.value === '') {
            newpassmsg.parent().find('.help-block.text-danger').remove();
            newpassmsg.after('<span class="help-block text-danger" style="display:block">Pin Code is required.</span>');
        } else {
            newpassmsg.parent().find('.help-block.text-danger').remove();
        }
    }

    function validateAddress(id) {
        const commInput = document.getElementById(id);
    
        commInput.value = commInput.value.replace(/\s{2,}/g, ' ');
    
        commInput.value = commInput.value.replace(/[^a-zA-Z0-9\s\-,./]/g, '');
    
        const newpassmsg = $('form [id="' + id + '"]');
    
        if (commInput.value === '') {
            newpassmsg.parent().find('.help-block.text-danger').remove();
            newpassmsg.after('<span class="help-block text-danger" style="display:block">Address field is required.</span>');
        } else {
            newpassmsg.parent().find('.help-block.text-danger').remove();
        }
    }

    function validateUTR(id) {
        const commInput = document.getElementById(id);    
        
        commInput.value = commInput.value.replace(/\s{1,}/g, ' ');

        commInput.value = commInput.value.replace(/[^a-zA-Z0-9\s]/g, '');
    
        const newpassmsg = $('form [id="' + id + '"]');
    
        if (commInput.value === '') {
            newpassmsg.parent().find('.help-block.text-danger').remove();
            newpassmsg.after('<span class="help-block text-danger" style="display:block">UTR field is required.</span>');
        } else {
            newpassmsg.parent().find('.help-block.text-danger').remove();
        }
    }

    function validatePan(id) {
        const commInput = document.getElementById(id);
    
        commInput.value = commInput.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
    
        const panRegex = /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/;
    
        const newpassmsg = $('form [id="' + id + '"]');
    
        if (commInput.value === '') {
            newpassmsg.parent().find('.help-block.text-danger').remove();
            newpassmsg.after('<span class="help-block text-danger" style="display:block">Field is required.</span>');
        } else {
            newpassmsg.parent().find('.help-block.text-danger').remove();
        }
    }

    function validateDesc(id) {
        const commInput = document.getElementById(id);
    
        commInput.value = commInput.value.replace(/\s{2,}/g, ' ');
    
        commInput.value = commInput.value.replace(/[^a-zA-Z0-9\s\-,./]/g, '');
    
        const newpassmsg = $('form [id="' + id + '"]');
    
        if (commInput.value === '') {
            newpassmsg.parent().find('.help-block.text-danger').remove();
            newpassmsg.after('<span class="help-block text-danger" style="display:block">Field is required.</span>');
        } else {
            newpassmsg.parent().find('.help-block.text-danger').remove();
        }
    }

    function validateGst(id) {
        const commInput = document.getElementById(id);
   
        commInput.value = commInput.value.replace(/[^A-Z0-9]/g, '');
    
        const gstinPattern = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[0-9][Z][0-9A-Z]{1}$/;
    
        const newpassmsg = $('form [id="' + id + '"]');
    
        if (!gstinPattern.test(commInput.value)) {
            newpassmsg.parent().find('.help-block.text-danger').remove();
            newpassmsg.after('<span class="help-block text-danger" style="display:block">The gstin field format is invalid.</span>');
        } else {
            newpassmsg.parent().find('.help-block.text-danger').remove();
        }
    }
    
