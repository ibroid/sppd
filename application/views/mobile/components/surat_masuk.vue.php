<script>
    const SuratMasuk = {
        template: `<?= vue_template('surat_masuk') ?>`,
        setup() {
            const route = useRoute();
            const dataSurat = ref({})
            const dataDisposisiOrder = ref([])
            const selectedDisposisi = ref()
            const disposisiValue = ref('')
            const isNotFound = ref(true)
            const btnSubmit = ref(null)
            const disposisiInput = ref(null)
            const disposisiList = ref([])
            const disposisiForm = ref(null)
            const pegawaiList = ref(null)


            const rules = [
                value => !!value || 'Tidak Boleh Kosong.',
                value => (value && value.length >= 3) || 'Min 3 characters',
            ];

            onMounted(fetchSurat)
            onMounted(fetchDisposisiOrder)
            onMounted(fetchDisposisiList)

            onMounted(() => {
                fetch('<?= base_url('api/pegawai_master/list') ?>').then((res) => {
                        if (!res.ok) {
                            throw new Error(res.statusText)
                        }
                        return res.json()
                    })
                    .then(res => pegawaiList.value = res)
                    .catch(err => {
                        console.log(err)
                    })
            })

            function fetchSurat() {
                fetch('<?= base_url('api/surat_masuk/show/') ?>' + route.params.id)
                    .then(res => {
                        if (!res.ok) {
                            throw new Error(res.statusText)
                        }
                        return res.json()
                    })
                    .then(res => {
                        dataSurat.value = res
                        isNotFound.value = false
                    })
                    .catch(err => {
                        isNotFound.value = true
                    })
            }

            function fetchDisposisiOrder() {
                fetch('<?= base_url('api/disposisi_surat/order') ?>')
                    .then(res => {
                        if (!res.ok) {
                            throw new Error(res.statusText)
                        }
                        return res.json()
                    })
                    .then(res => {
                        dataDisposisiOrder.value = res.data;
                    })
                    .catch(err => console.log(err))
            }

            function selectedDisposisiChange(e) {
                console.log('aspdjas')
            }

            function submitDisposisi() {
                if (disposisiValue.value == '') {
                    disposisiInput.value.focus()
                    return
                }
                // console.log(selectedDisposisi.value);
                // return;

                Swal.fire({
                    title: "Mohon Tunggu",
                    didOpen: () => Swal.showLoading(),
                    allowOutsideClick: false
                })

                const body = new FormData()
                body.append('isi_disposisi', disposisiValue.value);
                body.append('kepada', selectedDisposisi.value);
                body.append('surat_masuk_id', route.params.id);
                body.append('nomor_agenda', dataSurat.value.nomor_register);

                fetch('<?= base_url('api/disposisi_surat/save') ?>', {
                        method: 'POST',
                        body: body
                    })
                    .then(res => {
                        if (!res.ok) {
                            throw new Error(res.statusText)
                        }
                        return res.json()
                    })
                    .then(res => {
                        Swal.fire({
                            title: res.status
                        })
                        selectedDisposisi.value = 1;
                        disposisiValue.value = '';
                        disposisiForm.value.reset()
                        fetchDisposisiList()
                    })
                    .catch(err => {
                        console.log(err)

                    })
            }

            function fetchDisposisiList() {
                fetch('<?= base_url('api/disposisi_surat/list/') ?>' + route.params.id)
                    .then(res => {
                        if (!res.ok) {
                            throw new Error(res.statusText)
                        }
                        return res.json()
                    })
                    .then(res => {
                        disposisiList.value = res.data
                    })
                    .catch(err => {
                        console.log(err)
                    })
            }

            return {
                dataSurat,
                dataDisposisiOrder,
                selectedDisposisi,
                selectedDisposisiChange,
                disposisiValue,
                submitDisposisi,
                rules,
                isNotFound,
                btnSubmit,
                disposisiInput,
                disposisiList,
                disposisiForm,
                pegawaiList
            }
        }
    };

    routes.push({
        path: '/surat_masuk/:id',
        component: SuratMasuk
    })
</script>