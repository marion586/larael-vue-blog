<template>
    <div>
       <div class="content">
			<div class="container-fluid">	
				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Category <Button @click="addModal=true"><Icon type="md-add"/> Add Category</Button></p>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>ID</th>
								<th>Category Icon</th>
								<th>Category name</th>
								<th>Created at</th>
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->


								<!-- ITEMS -->
							<tr v-for="(category , i) in categoryLits" :key="i">
								<td>{{category.id}}</td>
								<td class="_table_image">
									<img :src="category.iconImage" alt="">
									</td>	
								<td class="_table_name">{{category.categoryName}}</td>
								<td>{{category.created_at}}</td>
								<td>

									<Button type="info" size="small" @click="showEditModal(category ,i)">edit</Button>
									<Button type="error" size="small"
									@click="showDeletingModal(category , i)"
									:loading="category.isDeleting"
									>delete</Button>
									
								</td>
							</tr>
								<!-- ITEMS -->

								<!-- ITEMS -->
						
						</table>
					</div>
				</div>
			<Modal
				v-model="addModal"
				title="Add category"
				:mask-closable="false"
				:closable="false"
				:draggable="true"
				>

				  <Input v-model="data.categoryName " placeholder="Add category name"  />

				  <div class="space">

				  </div>


				<Upload
						ref="uploads"
						type="drag"
						:headers = "{'x-csrf-token' : token ,'X-Requested-With':'XMLHttpRequest'}"
						:on-success="handleSuccess"
						:on-error="handleError"
						:format="['jpg','jpeg','png']"
						:max-size="2048"
						:on-format-error="handleFormatError"
						:on-exceeded-size="handleMaxSize"
						:show-upload-list='true'
						action="/app/upload">
						<div style="padding: 20px 0">
							<Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
							<p>Click or drag files here to upload</p>
						</div>
				</Upload>
				<div class="demo-upload-list" v-if="data.iconImage">
					<img :src="`/uploads/${data.iconImage}`" alt="">
					<div class="demo-upload-list-cover">
						<Icon type="ios-trash-outline" @click="deleteImage"></Icon>
					</div>
				</div>
				<div slot="footer">
					<Button type="default" @click="addModal = false"> close</Button>
					<Button type="primary" @click="addCategory" :disabled="isAdding" :loading="isAdding"> {{isAdding ? 'Adding ...' : 'Add category'}}</Button>
				</div>
			</Modal>

<!-- tag editing modal -->
			<Modal
				v-model="editModal"
				title="Edit Category"
				:mask-closable="false"
				:closable="false"
				:draggable="true"
				>
				  <Input v-model="data.categoryName " placeholder="Add category name"  />yqnr 

				  <div class="space">

				  </div>


				<Upload v-show="isIconImageNew"
						ref="uploads"
						type="drag"
						:headers = "{'x-csrf-token' : token ,'X-Requested-With':'XMLHttpRequest'}"
						:on-success="handleSuccess"
						:on-error="handleError"
						:format="['jpg','jpeg','png']"
						:max-size="2048"
						:on-format-error="handleFormatError"
						:on-exceeded-size="handleMaxSize"
						:show-upload-list='true'
						action="/app/upload">
						<div style="padding: 20px 0">
							<Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
							<p>Click or drag files here to upload</p>
						</div>
				</Upload>
				<div class="demo-upload-list" v-if="editData.iconImage">
					<img :src="`${editData.iconImage}`" alt="">
					<div class="demo-upload-list-cover">
						<Icon type="ios-trash-outline" @click="deleteImage"></Icon>
					</div>
				</div>

				<div slot="footer">
					<Button type="default" @click="editModal = false"> close</Button>
					<Button type="primary" @click="editTag" :disabled="isAdding" :loading="isAdding"> {{isAdding ? 'editing ...' : 'Adit tag'}}</Button>
				</div>
			</Modal>

			<!-- delete Modal  -->
			 <Modal v-model="showDeleteModal" width="360">
				<template #header>
					<p style="color:#f60;text-align:center">
						<Icon type="ios-information-circle"></Icon>
						<span>Delete confirmation</span>
					</p>
				</template>
				<div style="text-align:center">
					<p>Are you want to delete tag ?</p>
				</div>
				<template #footer>
					<Button type="error" size="large" long :loading="isDeleting" 
					:disabled="isDeleting"
					@click="deleteTag">Delete</Button>
				</template>
    </Modal>
			</div>
		</div>
    </div>
</template>

<script>

export default {
	data() {
		return {
			data : {
				iconImage: '',
				categoryName : ''
			},
			addModal : false,
			editModal: false,
			isAdding : false,
			categoryLits: [],
			editData: {
				iconImage: '',
				categoryName : ''
			},
			editIndex : 0,
			showDeleteModal: false ,
			deleteItem: {},
			deleteIndex: 0,
			isDeleting : false,
			token: '',
			isIconImageNew: false
		}
	},
	methods : {
		async addCategory(){
			
			if(this.data.categoryName.trim()== '') return this.e("Category name is required");
			 if(this.data.iconImage.trim()== '') return this.e("Icon image is required");
			 this.data.iconImage = `/uploads/${this.data.iconImage}`;
			const res = await this.$callApi('post' , 'app/create_category' , this.data);
			
			console.log(res)
			if(res.status === 201) {
				this.s('category has been added successfully')
				this.categoryLits.unshift(res.data);
				this.addModal = false;
				this.data.categoryName = "";
				this.data.iconImage = ""
				// this.getTag();
			}
			else {
				if(res.status == 422){
					if(res.data.errors.categoryName)
					{
						this.e(res.data.errors.categoryName[0])
					}
					if(res.data.errors.iconImage)
					{
						this.e(res.data.errors.categoryName[0])
					}
				
				}
				else{

					this.e()
				}
			}
		},
		async editTag(){
			 if(this.editData.tagName.trim()== '') return this.e("Tag name is required ");
			const res = await this.$callApi('post' , 'app/edit_tag' , this.editData)
			
			if(res.status === 200) {
				this.s('tag has been edited successfully')
				this.editModal = false;
				this.tags[this.index].tagName = this.editData.tagName;
				// this.getTag();
			}
			else {
				if(res.status == 422){
					if(res.data.errors.tagName)
					{
						this.e(res.data.errors.tagName[0])
					}
				
				}
				else{

					this.e()
				}
			}
		},
		async deleteTag(){
			this.isDeleting = true
			// if(!confirm('are you sure want to delete this tag ?')) return this.$set(tag,'isDeleting' ,true)
			// use this allow you to add a new property which does not exist before the 
			const res = await this.$callApi('post' , 'app/delete_tag' ,this.deleteItem);

			if(res.status === 200){
				this.tags.splice(this.deleteIndex ,1)
				this.s('tag has been deleted successfully')
			}
			else {
				this.e()
			}
			this.isDeleting = false;
			this.showDeleteModal= false;
		},
		showDeletingModal(tag , i){
			this.deleteItem = tag ;
			this.deleteIndex = i ;
			this.showDeleteModal= true;
		},

		showEditModal(category ,i) {
			// let obj = {
			// 	id : tag.id,
			// 	tagName : tag.tagName
			// }
			this.editData = category
			this.editModal = true;
			this.editIndex = i
		},
		async getTag() {
			const res = await this.$callApi('get' , 'app/get_category' );
			if(res.status == 200) {
				this.categoryLits = res.data;
			}
			else {
				this.e("can't access to data")
			}
		}
		,
            handleSuccess (res, file) {
               this.data.iconImage = res
            },
			handleError(res, file) {
               console.log(file);
			   console.log(res);
			   this.$Notice.warning({
                    title: 'The file format is incorrect',
                    desc: 'File format of ' + file.name + ' is incorrect, please select jpg or png.'
                });
            },
            handleFormatError (file) {
                this.$Notice.warning({
                    title: 'The file format is incorrect',
                    desc: 'File format of ' + file.name + ' is incorrect, please select jpg or png.'
                });
            },
            handleMaxSize (file) {
                this.$Notice.warning({
                    title: 'Exceeding file size limit',
                    desc: 'File  ' + file.name + ' is too large, no more than 2M.'
                });
            },
			async deleteImage() {
				let image = this.data.iconImage
				this.data.iconImage = ''
				this.$refs.uploads.clearFiles();
				const res = await this.$callApi('post' , 'app/delete_image', {imageName: image})
				if(res.status!=200) {
					this.data.iconImage = image
					this.e();
				}
			}
		
	}
	,
	created() {
			this.token = window.Laravel.csrfToken
			this.getTag();

		}
	
}
</script>