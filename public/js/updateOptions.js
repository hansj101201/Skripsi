function updateGudangOptions(urlPass, callback) {
    var url = urlPass
    $.ajax({
        url: url,
        method: 'GET',
        success: function(data) {
            console.log(data);
            // Kosongkan dulu opsi gudang yang ada
            $('#gudang').empty();

            // Tambahkan opsi pertama dengan nilai kosong
            $('#gudang').append($('<option>', {
                value: '',
                text: 'Pilih'
            }));
            // Tambahkan opsi gudang berdasarkan data yang diterima dari server
            data.forEach(function(gudang) {
                $('#gudang').append($('<option>', {
                    value: gudang.ID_GUDANG,
                    text: gudang.NAMA
                }));
            });
            if (typeof callback === 'function') {
                callback();
            }
        },
        error: function(xhr, status, error) {
            console.error('Terjadi kesalahan saat mengambil opsi gudang:', error);
        }
    });
}

function updateBarangOptions(urlPass, callback) {
    console.log("masuk");
    var url = urlPass;
    $.ajax({
        url: url,
        method: 'GET',
        success: function(data) {
            console.log(data);
            // Kosongkan dulu opsi gudang yang ada
            $('#barang_id_barang').empty();

            // Tambahkan opsi pertama dengan nilai kosong
            $('#barang_id_barang').append($('<option>', {
                value: '',
                text: 'Pilih'
            }));
            // Tambahkan opsi barang_id_barang berdasarkan data yang diterima dari server
            data.forEach(function(barang) {
                $('#barang_id_barang').append($('<option>', {
                    value: barang.ID_BARANG,
                    text: barang.ID_BARANG
                }));
            });

            // Panggil callback setelah selesai memperbarui opsi barang
            if (typeof callback === 'function') {
                callback();
            }
        },
        error: function(xhr, status, error) {
            console.error('Terjadi kesalahan saat mengambil opsi gudang:', error);
        }
    });
}

function updateDepoOptions(urlPass, callback) {
    var url = urlPass;
    $.ajax({
        url: url,
        method: 'GET',
        success: function(data) {
            console.log(data);
            // Kosongkan dulu opsi gudang yang ada
            $('#depo').empty();

            // Tambahkan opsi pertama dengan nilai kosong
            $('#depo').append($('<option>', {
                value: '',
                text: 'Pilih'
            }));
            // Tambahkan opsi depo berdasarkan data yang diterima dari server
            data.forEach(function(depo) {
                $('#depo').append($('<option>', {
                    value: depo.ID_DEPO,
                    text: depo.NAMA
                }));
            });
            if (typeof callback === 'function') {
                callback();
            }
        },
        error: function(xhr, status, error) {
            console.error('Terjadi kesalahan saat mengambil opsi gudang:', error);
        }
    });
}

function updateSupplierOptions(urlPass, callback) {
    var url = urlPass;
    $.ajax({
        url: url,
        method: 'GET',
        success: function(data) {
            console.log(data);
            // Kosongkan dulu opsi gudang yang ada
            $('#supplier').empty();

            // Tambahkan opsi pertama dengan nilai kosong
            $('#supplier').append($('<option>', {
                value: '',
                text: 'Pilih'
            }));
            // Tambahkan opsi supplier berdasarkan data yang diterima dari server
            data.forEach(function(supplier) {
                $('#supplier').append($('<option>', {
                    value: supplier.ID_SUPPLIER,
                    text: supplier.NAMA
                }));
            });
            if (typeof callback === 'function') {
                callback();
            }
        },
        error: function(xhr, status, error) {
            console.error('Terjadi kesalahan saat mengambil opsi gudang:', error);
        }
    });
}

function updateSalesOptions(urlPass, callback) {
    var url = urlPass;
    $.ajax({
        url: url,
        method: 'GET',
        success: function(data) {
            console.log(data);
            // Kosongkan dulu opsi gudang yang ada
            $('#sales').empty();

            // Tambahkan opsi pertama dengan nilai kosong
            $('#sales').append($('<option>', {
                value: '',
                text: 'Pilih'
            }));
            // Tambahkan opsi sales berdasarkan data yang diterima dari server
            data.forEach(function(sales) {
                $('#sales').append($('<option>', {
                    value: sales.ID_SALES,
                    text: sales.NAMA
                }));
            });
            if (typeof callback === 'function') {
                callback();
            }
        },
        error: function(xhr, status, error) {
            console.error('Terjadi kesalahan saat mengambil opsi gudang:', error);
        }
    });
}

function updateCustomerOptions(urlPass, callback) {
    var url = urlPass
    $.ajax({
        url: url,
        method: 'GET',
        success: function(data) {
            console.log(data);
            // Kosongkan dulu opsi gudang yang ada
            $('#customer').empty();

            // Tambahkan opsi pertama dengan nilai kosong
            $('#customer').append($('<option>', {
                value: '',
                text: 'Pilih'
            }));
            // Tambahkan opsi customer berdasarkan data yang diterima dari server
            data.forEach(function(customer) {
                $('#customer').append($('<option>', {
                    value: customer.ID_CUSTOMER,
                    text: customer.NAMA
                }));
            });
            if (typeof callback === 'function') {
                callback();
            }
        },
        error: function(xhr, status, error) {
            console.error('Terjadi kesalahan saat mengambil opsi gudang:', error);
        }
    });
}

function getNomorPO(urlPass) {
    var url = urlPass;
    $.ajax({
        url: url,
        method: 'GET',
        success: function(data) {
            console.log(data);
            // Kosongkan dulu opsi gudang yang ada
            $('#nomorpo').empty();

            // Tambahkan opsi pertama dengan nilai kosong
            $('#nomorpo').append($('<option>', {
                value: '',
                text: 'Pilih'
            }));
            // Tambahkan opsi gudang berdasarkan data yang diterima dari server
            data.forEach(function(nomor) {
                $('#nomorpo').append($('<option>', {
                    value: nomor.NOMORPO,
                    text: nomor.NOMORPO
                }));
            });
        },
        error: function(xhr, status, error) {
            console.error('Terjadi kesalahan saat mengambil opsi gudang:', error);
        }
    });
}

function updateGudangTujuanOptions(urlPass) {
    var url = urlPass;
    $.ajax({
        url: url,
        method: 'GET',
        success: function(data) {
            console.log(data);
            // Kosongkan dulu opsi gudang yang ada
            $('#gudang_tujuan').empty();

            // Tambahkan opsi pertama dengan nilai kosong
            $('#gudang_tujuan').append($('<option>', {
                value: '',
                text: 'Pilih'
            }));
            // Tambahkan opsi gudang berdasarkan data yang diterima dari server
            data.forEach(function(gudang) {
                $('#gudang_tujuan').append($('<option>', {
                    value: gudang.ID_GUDANG,
                    text: gudang.NAMA
                }));
            });
        },
        error: function(xhr, status, error) {
            console.error('Terjadi kesalahan saat mengambil opsi gudang:', error);
        }
    });
}

function updateNomorPo(urlPass) {
    var url = urlPass;
    $.ajax({
        url: url,
        method: 'GET',
        success: function(data) {
            console.log(data);
            // Kosongkan dulu opsi gudang yang ada
            $('#nomorpermintaan').empty();

            // Tambahkan opsi pertama dengan nilai kosong
            $('#nomorpermintaan').append($('<option>', {
                value: '',
                text: 'Pilih'
            }));
            // Tambahkan opsi nomorpermintaan berdasarkan data yang diterima dari server
            data.forEach(function(nomorpermintaan) {
                $('#nomorpermintaan').append($('<option>', {
                    value: nomorpermintaan.NOPERMINTAAN,
                    text: nomorpermintaan.NOPERMINTAAN
                }));
            });
        },
        error: function(xhr, status, error) {
            console.error('Terjadi kesalahan saat mengambil opsi gudang:', error);
        }
    });
}

function updateGudangTransferOptions(urlPass, callback) {
    var url = urlPass;
    $.ajax({
        url: url,
        method: 'GET',
        success: function(data) {
            console.log(data);
            // Kosongkan dulu opsi gudang yang ada
            $('#gudang, #gudang_tujuan').empty();

            // Tambahkan opsi pertama dengan nilai kosong
            $('#gudang, #gudang_tujuan').append($('<option>', {
                value: '',
                text: 'Pilih'
            }));
            // Tambahkan opsi gudang berdasarkan data yang diterima dari server
            data.forEach(function(gudang) {
                $('#gudang, #gudang_tujuan').append($('<option>', {
                    value: gudang.ID_GUDANG,
                    text: gudang.NAMA
                }));
            });
            if (typeof callback === 'function') {
                callback();
            }
        },
        error: function(xhr, status, error) {
            console.error('Terjadi kesalahan saat mengambil opsi gudang:', error);
        }
    });
}
