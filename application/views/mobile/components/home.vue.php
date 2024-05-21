<script>
     const Home = {
          template: `<?= vue_template('home') ?>`,
          setup() {

               const router = useRouter();

               const todayDate = () => {
                    let today = new Date();
                    let date = today.getDate();
                    let month = today.getMonth() + 1;
                    let year = today.getFullYear();

                    let dd = String(date).padStart(2, '0');
                    let mm = String(month).padStart(2, '0');

                    let formattedDate = year + '-' + mm + '-' + dd;

                    return formattedDate;
               }


               const alertShown = ref(false);
               const alertType = ref("success");
               const suratMasukList = ref(null)

               const selectedSurat = ref(null);
               const dialog = ref(false);

               const disposisiOrder = reactive([])

               onMounted(fetchSuratMasuk)

               function fetchSuratMasuk() {
                    fetch('<?= base_url('api/surat_masuk/list') ?>', {
                              method: "POST",
                              headers: {
                                   "Content-Type": "application/json"
                              },
                              body: JSON.stringify({
                                   date: todayDate()
                              })
                         })
                         .then((res) => {
                              if (!res.ok) {
                                   throw new Error(res.statusText)
                              }
                              return res.json()
                         })
                         .then(res => suratMasukList.value = res)
                         .catch(err => {
                              console.log(err)
                         })
               }


               function redirectSuratMasuk(id) {
                    router.push('/surat_masuk/' + id)
               }


               return {
                    suratMasukList,
                    selectedSurat,
                    redirectSuratMasuk,
                    alertShown,
                    alertType
               };

          }
     }
     routes.push({
          path: '/',
          component: Home
     })
</script>