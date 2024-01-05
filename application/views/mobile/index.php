<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('assets/favicon_mobile') ?>/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('assets/favicon_mobile') ?>/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('assets/favicon_mobile') ?>/favicon-16x16.png">
	<link rel="manifest" href="<?= base_url('assets/favicon_mobile') ?>/site.webmanifest">
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="theme-color" content="#ffffff">

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vuetify@3.3.6/dist/vuetify.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.2.96/css/materialdesignicons.css" />
	<title>ARDI Mobile</title>
	<style>
		body {
			width: 100%;
			max-width: 480px;
			margin: 0 auto;
		}
	</style>
</head>

<body>
	<div id="app" class="page-container">

		<v-app id="inspire">
			<v-app-bar color="primary" density="compact">
				<v-app-bar-title>ARDI Mobile</v-app-bar-title>
			</v-app-bar>

			<v-main>
				<router-view></router-view>
			</v-main>

			<v-bottom-navigation class="bg-primary" v-model="value" horizontal>
				<v-btn @click="redirectToHome">
					<v-icon class="primary">mdi-email-multiple-outline</v-icon>
					Persuratan
				</v-btn>
			</v-bottom-navigation>
		</v-app>
	</div>


	<script src="https://cdn.jsdelivr.net/npm/vue@3.3.4/dist/vue.global.prod.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/vuetify@3.3.6/dist/vuetify.min.js"></script>
	<script src="https://unpkg.com/vue-router@4.0.15/dist/vue-router.global.js"></script>
	<script src="<?= base_url('assets/vendors/sweetalert2/sweetalert2.all.min.js') ?>"></script>

	<script>
		const {
			createApp,
			onMounted,
			reactive,
			ref,
		} = Vue;

		const {
			createVuetify
		} = Vuetify;

		const {
			useRouter,
			useRoute
		} = VueRouter;

		const routes = [];
	</script>

	<?php foreach ($page as $p) {
		echo $p;
	} ?>

	<script>
		const router = VueRouter.createRouter({
			history: VueRouter.createWebHashHistory(),
			routes,
		})

		const vuetify = createVuetify()
		const app = createApp({
			setup() {
				const router = useRouter();

				function redirectToHome() {
					router.replace('/');
				}

				return {
					redirectToHome
				}
			}
		})
		app.use(router)
		app.use(vuetify)
		app.mount('#app')
	</script>
</body>

</html>