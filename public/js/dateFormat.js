function dateFormat (data) {
    if (data) {
        // Convert data to date object
        var date = new Date(data);
        // Format date as dd/mm/yyyy
        var formattedDate = ('0' + date.getDate()).slice(-2) + '-' + ('0' + (date.getMonth() + 1)).slice(-2) + '-' + date.getFullYear();
        return formattedDate;
    }
    return '';
 }
