(function ($) {
    "use strict";

    if (!$.wjbWcAdminExtensions)
        $.wjbWcAdminExtensions = {};
    
    function WJBWCAdminMainCore() {
        var self = this;
        self.init();
    };

    WJBWCAdminMainCore.prototype = {
        /**
         *  Initialize
         */
        init: function() {
            var self = this;

            self.mixes();
        },
        mixes: function() {
            var self = this;

            var val_package_type = $('#_job_package_package_type').val();
            self.changePackageTypeFn(val_package_type);
            $('#_job_package_package_type').on('change', function() {
                var val_package_type = $(this).val();
                self.changePackageTypeFn(val_package_type);
            });


            var val_detail = $('input[name=candidate_restrict_contact_info]:checked').val();
            var restrict_type = $('#candidate_restrict_type').val();
            self.changeRestrictCandidateFn(val_detail, restrict_type);
            $('input[name=candidate_restrict_contact_info]').on('change', function() {
                var val_detail = $('input[name=candidate_restrict_contact_info]:checked').val();
                var restrict_type = $('#candidate_restrict_type').val();
                self.changeRestrictCandidateFn(val_detail, restrict_type);
            });
            
            $('#candidate_restrict_type').on('change', function() {
                var restrict_type = $(this).val();
                var val_detail = $('input[name=candidate_restrict_contact_info]:checked').val();
                self.changeRestrictCandidateFn(val_detail, restrict_type);
            });
        },
        changePackageTypeFn: function(val_package_type) {
            if ( val_package_type == 'job_package' ) {
                $('#_job_package_job_package').css({'display': 'block'});
                //
                $('#_job_package_cv_package').css({'display': 'none'});
                $('#_job_package_contact_package').css({'display': 'none'});
                $('#_job_package_candidate_package').css({'display': 'none'});
                $('#_job_package_resume_package').css({'display': 'none'});
            } else if ( val_package_type == 'cv_package' ) {
                $('#_job_package_cv_package').css({'display': 'block'});
                //
                $('#_job_package_job_package').css({'display': 'none'});
                $('#_job_package_contact_package').css({'display': 'none'});
                $('#_job_package_candidate_package').css({'display': 'none'});
                $('#_job_package_resume_package').css({'display': 'none'});
            } else if ( val_package_type == 'contact_package' ) {
                $('#_job_package_contact_package').css({'display': 'block'});
                //
                $('#_job_package_job_package').css({'display': 'none'});
                $('#_job_package_cv_package').css({'display': 'none'});
                $('#_job_package_candidate_package').css({'display': 'none'});
                $('#_job_package_resume_package').css({'display': 'none'});
            } else if ( val_package_type == 'candidate_package' ) {
                $('#_job_package_candidate_package').css({'display': 'block'});
                //
                $('#_job_package_job_package').css({'display': 'none'});
                $('#_job_package_cv_package').css({'display': 'none'});
                $('#_job_package_contact_package').css({'display': 'none'});
                $('#_job_package_resume_package').css({'display': 'none'});
            } else if ( val_package_type == 'resume_package' ) {
                $('#_job_package_resume_package').css({'display': 'block'});
                //
                $('#_job_package_job_package').css({'display': 'none'});
                $('#_job_package_cv_package').css({'display': 'none'});
                $('#_job_package_contact_package').css({'display': 'none'});
                $('#_job_package_candidate_package').css({'display': 'none'});
            } else {
                $('#_job_package_resume_package').css({'display': 'none'});
                $('#_job_package_job_package').css({'display': 'none'});
                $('#_job_package_cv_package').css({'display': 'none'});
                $('#_job_package_contact_package').css({'display': 'none'});
                $('#_job_package_candidate_package').css({'display': 'none'});
            }
        },
        changeRestrictCandidateFn: function(val_detail, restrict_type) {
            if ( restrict_type == 'view_contact_info' && val_detail == 'register_employer_contact_with_package' ) {
                $('.cmb2-id-contact-package-page-id').css({'display': 'block'});
            } else {
                $('.cmb2-id-contact-package-page-id').css({'display': 'none'});
            }
        }
    }

    $.wjbWcAdminMainCore = WJBWCAdminMainCore.prototype;
    
    $(document).ready(function() {
        // Initialize script
        new WJBWCAdminMainCore();
    });
    
})(jQuery);

