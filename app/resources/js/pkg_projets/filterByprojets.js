$(document).ready(function() {
    function updateURLParameter(param, paramVal) {
        var url = window.location.href;
        var hash = window.location.hash;
        url = url.replace(hash, "");
        if (url.indexOf(param + "=") >= 0) {
            var prefix = url.substring(0, url.indexOf(param + "="));
            var suffix = url.substring(url.indexOf(param + "="));
            suffix = suffix.substring(suffix.indexOf("=") + 1);
            suffix = suffix.indexOf("&") >= 0 ? suffix.substring(suffix.indexOf("&")) : "";
            url = prefix + param + "=" + paramVal + suffix;
        } else {
            if (url.indexOf("?") < 0) url += "?" + param + "=" + paramVal;
            else url += "&" + param + "=" + paramVal;
        }
        window.history.replaceState({ path: url }, "", url + hash);
    }

    function fetchTasks(params) {
        var taskContainer = $('#taskContainer');
        $.ajax({
            url: "/projets/projets/taches/digramme-de-gantt",

            type: 'GET',
            data: params,
            success: function(data) {
                taskContainer.html(data);
                mermaid.init(undefined, taskContainer.find('.mermaid'));
            },
            error: function(error) {
                console.error('Error fetching tasks:', error);
                taskContainer.html('<div class="alert alert-danger mt-3"><strong>Failed to load tasks.</strong></div>');
            }
        });
    }

    $('#projectSelect').change(function() {
        var projectId = $(this).val();
        updateURLParameter('project_id', projectId);
        fetchTasks({ project_id: projectId });
    });

    $('#table_search').on('input', function() {
        var searchValue = $(this).val();
        fetchTasks({ searchValue: searchValue });
    });
});

console.log(565636636);