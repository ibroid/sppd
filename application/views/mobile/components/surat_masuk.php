<v-card v-if="isNotFound === true">
    <v-card-item>
        <v-card-title>Not Found</v-card-title>
    </v-card-item>
</v-card>
<v-card v-else>

    <v-card-item>
        <v-card-title v-text="dataSurat.perihal"></v-card-title>
        <v-card-subtitle v-text="dataSurat.asal"></v-card-subtitle>
    </v-card-item>

    <v-card-text v-text="dataSurat.ringkasan_isi">
    </v-card-text>
    <v-card-text>Tanggal Surat : {{dataSurat.tanggal_surat}}</v-card-text>
    <v-card-text>Tanggal Diterima : {{dataSurat.tanggal_diterima}}</v-card-text>

    <v-card-text prepend-icon="mdi-file" v-if="dataSurat.file">
        <form method="POST" action="<?= base_url('api/surat_masuk/download') ?>" target="_blank">
            <input type="hidden" name="id" :value="dataSurat.id">
            <v-btn type="submit" class="bg-warning" prepend-icon="mdi-download">
                <template v-slot:prepend>
                    <v-icon></v-icon>
                </template>
                Download
            </v-btn>
        </form>
    </v-card-text>

    <v-divider></v-divider>

    <v-card-item>
        <v-card-title>
            Riwayat Disposisi
        </v-card-title>

        <v-table>
            <thead>
                <tr class="bg-teal-lighten-2">
                    <th class="text-left text-white">
                        No
                    </th>
                    <th class="text-left text-white">
                        Kepada
                    </th>
                    <th class="text-left text-white">
                        Catatan
                    </th>
                </tr>
            </thead>
            <tbody class="bg-teal-lighten-5">
                <tr v-for="(item,i) in disposisiList" :key="item.id">
                    <td>{{++i}}</td>
                    <td>{{item.pegawai.nama}} ({{item.pegawai.jabatan.nama_jabatan}})</td>
                    <td>{{item.isi_disposisi}}</td>
                </tr>
                <tr v-if="disposisiList.length <= 0">
                    <td colspan="3" class="text-center">Belum ada disposisi</td>
                </tr>
            </tbody>
        </v-table>
    </v-card-item>

    <v-card-item v-if="disposisiList.length > 0">
        <form method="POST" action="<?= base_url('api/disposisi_surat/cetak') ?>" target="_blank">
            <input type="hidden" name="id" :value="dataSurat.id">
            <v-btn type="submit" class="bg-teal" prepend-icon="mdi-file">
                <template v-slot:prepend>
                    <v-icon></v-icon>
                </template>
                Cetak
            </v-btn>
        </form>
    </v-card-item>


    <v-form ref="disposisiForm">
        <v-card-item>
            <v-card-subtitle>Disposisi Surat ke:</v-card-subtitle>
            <!-- <v-select item-title="nama_jabatan" item-value="id" required label="Pilih Pegawai" :items="dataDisposisiOrder" v-model="selectedDisposisi"></v-select> -->
            <v-autocomplete v-model="selectedDisposisi" required label="Ketik nama pegawai" item-title="nama" item-value="id" :items="pegawaiList"></v-autocomplete>
        </v-card-item>

        <v-card-item>
            <v-card-subtitle>Isi Disposisi:</v-card-subtitle>
            <v-textarea ref="disposisiInput" label="Tulis catatan" :rules="rules" v-model="disposisiValue" hide-details="auto"></v-textarea>
        </v-card-item>

        <v-card-item>
            <v-btn ref="btnSubmit" @click="submitDisposisi" prepend-icon="mdi-send" block class="bg-success">
                <template v-slot:prepend>
                    <v-icon></v-icon>
                </template>
                Kirim
            </v-btn>
        </v-card-item>
    </v-form>
</v-card>