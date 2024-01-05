<div>
    <v-alert v-if="alertShown" class="mx-2 my-2" density="compact" :type="alertType" title="Alert title" text="Lorem ipsum dolor sit amet consectetur adipisicing elit. Commodi, ratione debitis quis est labore voluptatibus! Eaque cupiditate minima, at placeat totam, magni doloremque veniam neque porro libero rerum unde voluptatem!"></v-alert>
    <v-list>
        <v-list-subheader>Daftar Surat Masuk</v-list-subheader>
        <v-list-item @click="redirectSuratMasuk(item.id)" v-for="(item, i) in suratMasukList" :key="i" :value="item">
            <v-list-item-title v-text="item.perihal"></v-list-item-title>
            <v-list-item-subtitle v-html="item.asal"></v-list-item-subtitle>
            <template v-slot:prepend>
                <v-avatar color="grey-lighten-1">
                    <v-icon color="white" icon="mdi-email-arrow-left"></v-icon>
                </v-avatar>
            </template>
            <v-list-group>
                <v-list-item-subtitle v-html="item.ringkasan_isi"></v-list-item-subtitle>
            </v-list-group>
        </v-list-item>
        <v-divider></v-divider>
        <v-list-subheader>Daftar Surat Keluar</v-list-subheader>
    </v-list>
</div>