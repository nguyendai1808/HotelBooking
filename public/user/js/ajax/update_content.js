$(document).ready(function () {
    selectMenuItem();

    $('#sidebar').on('click', 'li', function (e) {
        $('#sidebar li').removeClass('selected');
        $(this).addClass('selected');

        var url = $(this).data('url');
        loadPersonalInfo(url);
        history.pushState(null, '', url);
    });

    function loadPersonalInfo(url) {
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#main-content').html(data.page);
            },
            error: function (xhr, status, error) {
                console.error('Error loading content:', error);
            }
        });
    }

    function selectMenuItem() {
        var currentUrl = window.location.href.toLowerCase();
        $('#sidebar li').each(function () {
            if ($(this).data('url').toLowerCase() === currentUrl) {
                $('#sidebar li').removeClass('selected');
                $(this).addClass('selected');
            }
        });
    }
});
