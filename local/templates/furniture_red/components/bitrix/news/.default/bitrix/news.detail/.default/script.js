const ajaxReport = (url, newsId) => {
    BX.ajax.loadJSON(
        url,
        {
            R: 'Y'
        },
        (response) => {
            document.getElementById('report-msg').textContent = response.content;
        },
    )
}