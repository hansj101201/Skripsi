function submitForm(formData, url, type, successCallback, errorCallback) {
    $.ajax({
        type: type,
        url: url,
        data: formData,
        processData: false,
        contentType: false,
        success: successCallback,
        error: errorCallback
    });
}


