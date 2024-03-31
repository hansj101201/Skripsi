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

function getPeriode($tanggal) {
    var parts = $tanggal.split('-');
    var day = parseInt(parts[0], 10); // Konversi string menjadi integer untuk hari
    var month = parseInt(parts[1], 10); // Konversi string menjadi integer untuk bulan
    var year = parseInt(parts[2], 10); // Konversi string menjadi integer untuk tahun

    // Buat objek Date menggunakan tahun, bulan (dikurangi 1 karena bulan dimulai dari 0), dan hari
    var date = new Date(year, month - 1, day);

    // Ambil tahun dan bulan dari objek Date
    var yyyy = date.getFullYear();
    var mm = date.getMonth() + 1; // Tambahkan 1 karena bulan dimulai dari 0

    // Format tahun dan bulan menjadi format yyyymm
    var yyyymm = yyyy.toString() + (mm < 10 ? '0' : '') + mm.toString();

    console.log(yyyymm); // Output format yyyymm ke konsol
    return yyyymm;
}

function formatHarga(harga) {
    // Menggunakan metode toLocaleString untuk mengonversi angka menjadi format dengan pemisah ribuan
    return harga.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
