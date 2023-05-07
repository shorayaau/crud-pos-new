var controller = new Vue({
    el: '#controller',
    data: {
        editStatus: false,
        data: {},
        anggota: {},
        actionUrl: actionUrl,
        datas: [],
    },
    mounted: function () {
        this.datatable()
    },
    methods: {
        datatable() {
            const _this = this;
            _this.table = $('#datatable').DataTable({
                responsive: {
                    details: {
                        type: 'column'
                    }
                },
                ajax: {
                    url: _this.actionUrl,
                    type: 'get',
                },
                columns: columns
            }).on('xhr', function () {
                _this.datas = _this.table.ajax.json().data
            })
        },
        addData() {
            $('#modal-default').modal()
            this.editStatus = false
            this.data = {}
        },
        editData(event, index) {
            $('#modal-default').modal()
            this.editStatus = true
            this.data = this.datas[index];
        },
        editDataPeminjaman(event, index) {
            this.editStatus = true;
            this.data = this.datas[index];

            $('#select2-buku').empty();
            var option = '';

            for (var i = 0; i < this.data.list_buku.length; i++) {
                console.log(this.data.list_buku[i]['dipinjam'])
                option = option + `<option ` + (this.data.list_buku[i]['dipinjam'] == true ? `selected` : ``) + ` value="` + this.data.list_buku[i]['id'] + `">` + this.data.list_buku[i]['judul'] + `</option>`;
            }
            //console.log(option)
            $('#select2-buku').append(option);
            $('#modal-default').modal();
        },
        deleteData(event, id) {
            if (confirm('Are you sure?')) {
                axios.post(this.actionUrl + '/' + id, {
                        _method: 'DELETE'
                    })
                    .then(response => {
                        $(event.target).parents('tr').remove();
                        console.log('Data has been deleted')
                    })
                    .catch(error => {
                        alert(error.response.data.message)
                    })
            }
        },
        detailData(event, index) {
            this.editStatus = true;
            this.data = this.datas[index];
            this.anggota = this.data.anggota;

            $('#modal-detail').modal();
        },
        formatPrice(value) {
            let val = (value / 1).toFixed(0).replace('.', ',')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
        submitForm(event, id) {
            event.preventDefault()
            const _this = this
            var actionUrl = !this.editStatus ? this.actionUrl : this.actionUrl + '/' + id;
            axios.post(actionUrl, new FormData($(event.target)[0]))
                .then(response => {
                    $('#modal-default').modal('hide')
                    _this.table.ajax.reload()
                })
                .catch(error => {
                    alert(error.response.data.message)
                })
        }
    }
})
