<template>
    <div class="home-container">
        <div class="background-overlay">
        </div>
        <div class="grid-container">
            <div class="folder-icon" v-for="forder in forders" :key="forder.id">
                <router-link :to="{ name: 'FileList', params: { id: forder.id } }" class="folder-link">
                    <img src="/images/folder.png" class="folder-image" alt="Folder Icon">
                    <p class="folder-name" style="font-size: 85%; font-weight: 600;">{{ forder.name }}</p>
                </router-link>
            </div>
        </div>

        <div class="px-1 mt-4">
            <p class="px-2 mb-2" style="font-size: 95%; font-weight: 500;">File Uploaded Recently</p>
            <div class="file-item mt-0" v-for="file in files">
                <div class="image-item">
                    <img :src="`/images/icons/files_type/${file.type}.png`">
                </div>
                <div class="file-details">
                    <p class="file-name">{{ file.name }}</p>
                    <p class="file-date">{{ file.created_at }}</p>
                </div>
                <div class="file-actions">
                    <i @click="$event => download(file.id, file.name)" class="fa fa-cloud-download text-blue-600 mt-1" aria-hidden="true"></i>
                    <i @click="$event => deleteFile(file.id)" class="fa fa-trash text-red-600 mt-2" aria-hidden="true"></i>
                </div>
            </div>
        </div>

        <router-link :to="{ name: 'ForderCreate' }">
            <div class="text-center" style="width: 50px; height: 50px; background: #1d4ed8; position: fixed; border-radius: 50px; right: 10px; top: 87vh;">
                <i class="fa fa-folder-open" aria-hidden="true" style="font-size: 140%; line-height: 48px; color: white;"></i>
            </div>
        </router-link>
    </div>
</template>

<script>
export default {
    data() {
        return {
            forders: [],
            files: []
        };
    },
    created() {
        this.getData();
    },
    methods: {
        async getData() {
            try {
                const { data } = await axios.get('api/home/get-data');
                this.forders = data.forders;
                this.files = data.files;
                console.log(data);
            } catch (error) {
                console.log(error);
            }
        },
        async download(id, name) {
            try {
                const response = await axios.get(`/api/file/download/${id}`, { responseType: 'blob' });
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', name);
                document.body.appendChild(link);
                link.click();
            } catch (error) {
                console.log(error);
            }
        },
        async deleteFile(id) {
            try {
                const { data } = await axios.get(`/api/file/delete/${id}`);
                if (data) {
                    this.getData();
                }
            } catch (error) {
                console.log(error);
                Swal.fire(error?.response?.data?.message);
            }
        }
    }
}
</script>

<style>
.home-container {
    position: relative;
    min-height: 100vh;
    padding: 16px;
    overflow: hidden;
}

.background-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: url('/images/background.jpg');
    background-size: cover;
    background-position: center;
    opacity: 0.3; /* Adjust the opacity value as needed */
    z-index: -1;
}

.grid-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
    gap: 16px;
}

.folder-icon {
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    margin: 0 auto;
}

.folder-link {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-decoration: none;
    color: inherit;
}

.folder-image {
    width: 60px;
    height: auto;
}

.folder-name {
    font-size: 0.875rem;
    font-weight: 600;
    margin-top: 0.5rem;
    text-align: center;
    word-wrap: break-word;
    white-space: normal;
    display: -webkit-box;
    -webkit-line-clamp: 2; /* max line */
    -webkit-box-orient: vertical;
    overflow: hidden;
    max-width: 60px;
}

.file-item {
    display: flex;
    align-items: center;
    padding: 8px;
}

.image-item {
    width: 52px;
    height: 67px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.image-item img {
    max-width: 100%;
    max-height: 100%;
}

.file-details {
    flex-grow: 1;
    padding-left: 16px;
}

.file-name {
    font-size: 90%;
    font-weight: 600;
    margin-top: 0;
}

.file-date {
    font-size: 90%;
    font-weight: 500;
    opacity: 0.5;
    margin-top: 4px;
}

.file-actions {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    padding-left: 16px;
}

.file-actions i {
    font-size: 24px;
    cursor: pointer;
}

.floating-icon {
    width: 50px;
    height: 50px;
    background: rgb(84, 150, 242);
    position: fixed;
    border-radius: 50%;
    right: 10px;
    bottom: 10px;
    display: flex;
    justify-content: center;
    align-items: center;
    opacity: 0.75;
    cursor: pointer;
    z-index: 1000;
}

.floating-icon i {
    font-size: 140%;
    color: white;
}
</style>
