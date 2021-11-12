var language = {
  "decimal": "",
  "emptyTable": "Data tidak tersedia",
  "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
  "infoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
  "infoFiltered": "(Difilter dari _MAX_ total data)",
  "infoPostFix": "",
  "thousands": ",",
  "lengthMenu": "Menampilkan _MENU_ data",
  "loadingRecords": "Memuat...",
  "processing": "Memproses...",
  "search": "Cari:",
  "zeroRecords": "Pencarian tidak ditemukan",
  "paginate": {
    "first": "Pertama",
    "last": "Terakhir",
    "next": "Selanjutnya",
    "previous": "Sebelumnya"
  }
};
var loading = `<div class="h4 text-center"><i class="fas fa-pulse fa-spinner"></i></div>`
var modalLoading = () => {
  $("#modal .modal-title").html(`<h5>Memuat data ...</h5>`);
  $("#modal .modal-body").html(loading);
  $("#modal").modal('show');
}

var loadFormModal = (table, url) => {
  modalLoading();
  $.get(url, {}, function (res) {
    $("#modal .modal-title").html(res.title);
    $("#modal .modal-body").html(res.form);
    $("#form").off().on('submit', function (e) {
      e.preventDefault();
      var form = $(this).serialize();
      var _this = $(this);
      _this.find('*').prop('disabled', true);
      _this.find('button').text('Menyimpan ...');
      $.ajax({
        url: $("#form").attr('action'),
        type: 'post',
        dataType: 'json',
        data: form,
        success: function (res) {
          toastr.remove();
          toastr.success(res.message);
          table.ajax.reload();
          _this.find('*').prop('disabled', false);
          _this.find('button').text('Simpan');
          $("#modal").modal('hide');
        },
        error: function (err) {
          toastr.remove();
          try {
            var errors = JSON.parse(err.responseText);
            var errMsg = errors.errors[Object.keys(errors.errors)[0]][0];
            toastr.error(errMsg);
          } catch (error) {
            toastr.error(err.responseJSON.message);
          }
          _this.find('*').prop('disabled', false);
          _this.find('button').text('Simpan');
        }
      });
    });
    if ($(".cpicker").length > 0) {
      $(".cpicker").colorpicker();
      $('.cpicker').on('colorpickerChange', function (event) {
        $('.cpicker .fa-square').css('color', event.color.toString());
      })
    }
  }, 'json');
}
var destroyData = (table, url) => {
  toastr.warning('Menghapus data ...')
  $.get(url, {}, function (res) {
    toastr.remove();
    toastr.success(res.message)
    table.ajax.reload();
  }, 'json').fail(function (err) {
    try {
      toastr.error(err.responseJSON.message);
    } catch (error) {
      toastr.error(err.responseJSON);
    }
  });
}

$(function () {
  if ($("#cat-table").length > 0) {
    var table = $("#cat-table").DataTable({
      language: language,
      processing: true,
      serverSide: true,
      responsive: true,
      autoWidth: false,
      ajax: location.href,
      columns: [
        { data: 'action', name: 'action', orderable: false, searchable: false },
        { data: 'name', name: 'name' },
        { data: 'description', name: 'description' },
        { data: 'position', name: 'position' },
        { data: 'active', name: 'active' },
        { data: 'linkscount', name: 'linkscount', orderable: false, searchable: false },
      ],
      'drawCallback': function (settings) {
        $(".confirm").on('click', function (e) {
          e.preventDefault();
          var txt = $(this).data('text');
          if (confirm(txt)) {
            destroyData(table, $(this).attr('href'));
          }
        });
        $(".edit").on("click", function (e) {
          e.preventDefault();
          loadFormModal(table, $(this).attr('href'));
        });
      }
    });
    $("#add-cat").off().on("click", function (e) {
      e.preventDefault();
      loadFormModal(table, $(this).attr('href'));
    });
  }
  if ($("#link-table").length > 0) {
    var table = $("#link-table").DataTable({
      language: language,
      processing: true,
      serverSide: true,
      responsive: true,
      autoWidth: false,
      ajax: location.href,
      columns: [
        { data: 'action', name: 'action', orderable: false, searchable: false },
        { data: 'name', name: 'name' },
        { data: 'description', name: 'description' },
        { data: 'dcat', name: 'dcat', orderable: false, searchable: false },
        { data: 'link', name: 'link' },
        { data: 'position', name: 'position' },
        { data: 'active', name: 'active' },
        { data: 'hits', name: 'hits' },
      ],
      'drawCallback': function (settings) {
        $(".confirm").on('click', function (e) {
          e.preventDefault();
          var txt = $(this).data('text');
          if (confirm(txt)) {
            destroyData(table, $(this).attr('href'));
          }
        });
        $(".edit").on("click", function (e) {
          e.preventDefault();
          loadFormModal(table, $(this).attr('href'));
        });
        $(".get-link").click(function (e) {
          e.stopPropagation();
          e.stopImmediatePropagation();
          var $tempElement = $("<input>");
          $("body").append($tempElement);
          $tempElement.val($(this).text()).select();
          document.execCommand("Copy");
          $tempElement.remove();
          alert("Link " + $(this).closest('tr').find('td:nth-child(2)').text() + " berhasil di salin!");
        })
      }
    });
    $("#add-link").off().on("click", function (e) {
      e.preventDefault();
      loadFormModal(table, $(this).attr('href'));
    });
  }
  if ($("#link-dest").length > 0) {
    setTimeout(() => {
      location.href = $("#link-dest").attr("href").trim();
    }, 3000);
  }
  if ($("#content").find(".cat").length > 0) {
    $("#content").find(".cat").each(function () {
      $(this).off().on("click", function () {
        $(this).parent().find(".link").toggleClass("show");
      });
    });
  }
});