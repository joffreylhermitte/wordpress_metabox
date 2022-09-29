<?php
function registerMetaAdminMenu() {
    add_menu_page(
        'Meta',
        'Meta',
        'manage_options',
        'meta-creation',
        'meta_page',
        'dashicons-admin-tools',

    );
}
add_action( 'admin_menu', 'registerMetaAdminMenu' );

function meta_page() {
    gestionMeta();
}

function gestionMeta(){
    $args = array(
        'show_ui'   => true,
        '_builtin' => false
    );
    $allPost = get_post_types($args);
    $pages = get_pages();
    ?>
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <style>
        .mb-20 {
            margin-bottom: 20px;
        }
    </style>
    <div class="wrap" id="app">
        <h2 class="wp-heading-inline">
            Création meta</h2>

        <div class="mb-20">
            <label for="fichierField">Nom du fichier </label>
            <input type="text" id="fichierField" v-model="fichierMeta">
        </div>
        <div class="mb-20">
            <label for="fonctionsField">Nom des fonctions </label>
            <input type="text" id="fonctionsField" v-model="nomFonctions">
        </div>
        <div class="mb-20">
            <label for="typePost">Type de post </label>
            <select id="typePost" v-model="postType">
                <option value="">Type</option>
                <option value="page">Page</option>
                <?php foreach ($allPost as $key=>$value):?>
                    <option value="<?=$key?>"><?=ucfirst($value)?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-20" v-if="postType === 'page'">
            <label for="pageId">Page</label>
            <select id="pageId" v-model="pageId">
                <option value="">---</option>
                <?php foreach ($pages as $page):?>
                    <option value="<?=$page->ID?>"><?=$page->post_title?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div style="margin-bottom: 50px">
            <label for="nonceField">Nom wp nonce </label>
            <input type="text" id="nonceField" v-model="nonceField">
        </div>
        <div class="mb-20">
            <label for="typeField">Type de champ</label>
            <select id="typeField" v-model="typeMeta">
                <option value="">Type</option>
                <option value="Field">Field</option>
                <option value="ImageField">ImageField</option>
                <option value="SelectField">SelectField</option>
                <option value="PostSelectField">PostSelectField</option>
                <option value="PostSelectField">PostCheckboxField</option>
                <option value="SelectPageField">SelectPageField</option>
                <option value="FileLinkField">FileLinkField</option>
                <option value="FileField">FileField</option>
                <option value="BundleImageField">BundleImageField</option>
                <option value="BundleField">BundleField</option>
            </select>
        </div>
        <div class="mb-20">
            <label for="nomField">Nom de la meta</label>
            <input type="text" id="nomField" v-model="nomMeta">
        </div>
        <div class="mb-20">
            <label for="labelField">Label</label>
            <input type="text" id="labelField" v-model="labelMeta">
        </div>
        <div class="mb-20" v-if="typeMeta === 'Field'">
            <label for="typeTextField">Type de texte</label>
            <select id="typeTextField" v-model="typeField">
                <option value="">Type</option>
                <option value="text">Texte</option>
                <option value="wysiwyg">WYSIWYG</option>
            </select>
        </div>
        <div class="mb-20" v-if="typeMeta === 'ImageField' || typeMeta === 'FileField' || typeMeta === 'BundleImageField'">
            <label for="labelBoutonField">Nom du bouton upload</label>
            <input type="text" id="labelBoutonField" v-model="boutonMeta">
        </div>
        <div class="mb-20" v-if="typeMeta === 'SelectField'">
            <label for="optionsField">Options</label>
            <input type="text" id="optionsField" v-model="optionsMeta">
        </div>
        <div class="mb-20" v-if="typeMeta === 'PostSelectField' || typeMeta === 'PostCheckboxField'">
            <label for="postField">Type de post</label>
            <input type="text" id="postField" v-model="postMeta">
        </div>
        <div class="mb-20" v-if="typeMeta === 'BundleImageField' || typeMeta === 'BundleField'">
            <label for="nombreField">Nombre </label>
            <input type="text" id="nombreField" v-model="nombreMeta">
        </div>



        <button @click="addMeta()" class="button" style="margin-top: 20px">Ajouter une meta</button>

        <div v-if="allMetas.length > 0">
            <ul>
                <li v-for="(meta,index) in allMetas">{{meta.label}} - {{meta.type}} - {{meta.nom}} <span @click="deleteMeta(index)" style="cursor: pointer;color: red;font-size: 1.1em">&times;</span></li>
            </ul>
        </div>
        <div style="margin-top: 30px">
            <button @click="createMeta()" class="button">Valider</button>
        </div>


        <h2 class="wp-heading-inline">
            Création post</h2>

        <div class="mb-20">
            <label for="newPostName">Nom du post </label>
            <input type="text" id="newPostName" v-model="newPostName">
        </div>
        <div class="mb-20">
            <label for="newSinglePostName">Nom singulier du post </label>
            <input type="text" id="newSinglePostName" v-model="newSinglePostName">
        </div>
        <div class="mb-20">
            <label for="newPostAllName">Phrase pour all items </label>
            <input type="text" id="newPostAllName" v-model="newPostAllName">
        </div>
        <div class="mb-20">
            <label for="newPostSlug">Slug du post </label>
            <input type="text" id="newPostSlug" v-model="newPostSlug">
        </div>
        <div class="mb-20">
            <label for="newPostLogo">Logo du post </label>
            <input type="text" id="newPostLogo" v-model="newPostLogo">
        </div>

        <div style="margin-top: 30px">
            <button @click="createPost()" class="button">Créer</button>
        </div>



    </div>

    <script>
        let app = new Vue({
            el: '#app',
            data: {
                typeMeta: '',
                nomMeta: '',
                labelMeta: '',
                typeField: '',
                boutonMeta: '',
                optionsMeta: '',
                postMeta: '',
                nombreMeta: '',
                allMetas: [],
                fichierMeta: '',
                nomFonctions: '',
                postType: '',
                nonceField: '',
                pageId: '',
                newPostName: '',
                newSinglePostName: '',
                newPostAllName: '',
                newPostSlug: '',
                newPostLogo: '',

            },
            mounted() {},
            methods: {
                addMeta(){
                    let obj = {
                        type: this.typeMeta,
                        nom: this.nomMeta,
                        label: this.labelMeta,
                        texte: this.typeField,
                        bouton: this.boutonMeta,
                        options: this.optionsMeta,
                        post: this.postMeta,
                        nombre: this.nombreMeta
                    }
                    this.allMetas.push(obj);
                    this.typeMeta = "";
                    this.nomMeta = "";
                    this.labelMeta = "";
                    this.boutonMeta = "";
                    this.typeField = "";
                    this.optionsMeta = "";
                    this.postMeta = "";
                    this.nombreMeta = "";
                },
                createMeta(){
                    let data = new FormData();
                    data.append('action','ajaxmeta');
                    data.append('fields',JSON.stringify(this.allMetas));
                    data.append('fichier',this.fichierMeta);
                    data.append('nomFonction',this.nomFonctions);
                    data.append('typePost',this.postType);
                    data.append('nonceField',this.nonceField);
                    data.append('pageId',this.pageId);
                    axios.post(window.location.origin + "/wp-admin/admin-ajax.php",data)
                        .then(res => {
                            if (res.data === 'ok'){
                                alert('Fichier créé');
                                location.reload();
                            } else {
                                console.log(res.data);
                            }
                        })
                        .catch(err => console.log(err))

                },
                deleteMeta(index){
                    this.allMetas.splice(index, 1);
                },
                createPost(){
                    let data = new FormData();
                    data.append('action','ajaxpost');
                    data.append('newPostName',this.newPostName);
                    data.append('newSinglePostName',this.newSinglePostName);
                    data.append('newPostAllName',this.newPostAllName);
                    data.append('newPostSlug',this.newPostSlug);
                    data.append('newPostLogo',this.newPostLogo);

                    axios.post(window.location.origin + "/wp-admin/admin-ajax.php",data)
                        .then(res => {
                            if (res.data === 'ok'){
                                alert('Post créé');
                                location.reload();
                            } else {
                                console.log(res.data);
                            }
                        })
                        .catch(err => console.log(err))

                }
            }
        })
    </script>
    <?php
}
