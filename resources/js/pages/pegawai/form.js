Alpine.data('pegawai_form', () => ({
    formData: {
        skpd: '',
        bidang: '',
        nip: '',
        nama: '',
        password: '',
        password_confirmation: '',
    },
    validationErrors: {},

    async initData(uuid) {
        let res = await axios.get(`/pegawai/${uuid}`);
        let data = res.data;

        data.skpd = data.skpd.uuid;
        data.bidang = data.bidang.uuid;

        for (let key in this.formData) {
            if (data.hasOwnProperty(key)) {
                this.formData[key] = data[key];
            }
        }

        $('#skpd').val(data.skpd).change();
    },

    async submit() {
        let formData = new FormData();

        for (let key in this.formData) {
            formData.append(key, this.formData[key]);
        }

        try {
            if (uuid) {
                formData.append('_method', 'PUT');

                await axios.post(`/pegawai/${uuid}`, formData);
            } else {
                await axios.post('/pegawai', formData);
            }

            window.location.href = '/pegawai';
        } catch (err) {
            if (err.response?.status === 422) {
                this.validationErrors = err.response.data.errors ?? {};
            } else {
                toastr.error('Terjadi kesalahan sistem. Silahkan refresh halaman ini. Jika error masih terjadi, silahkan hubungi Tim IT.');
            }
        }
    },

    initSelect2() {
        let initData = init()
        onSkpdChange(initData.bidangElement);

        function onSkpdChange(bidangElement) {
            console.log(bidangElement)
        }

        function init() {
            let bidangElement = $('#bidang');

            emptySelectWithPlaceholder(bidangElement, 'Pilih SKPD Terlebih Dahulu')

            bidangElement.val('').change();

            return {bidangElement}
        }
    }
}));
