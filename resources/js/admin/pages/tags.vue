<template>
    <div>
       <div class="content">
			<div class="container-fluid">	
				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Tags <Button @click="addModal=true"><Icon type="md-add"/> Add tag</Button></p>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>ID</th>
								<th>Tag name</th>
								<th>Created at</th>
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->


								<!-- ITEMS -->
							<tr v-for="(tag , i) in tags" :key="i">
								<td>{{tag.id}}</td>	
								<td class="_table_name">{{tag.tagName}}</td>
								<td>{{tag.created_at}}</td>
								<td>

									<Button type="info" size="small" @click="showEditModal(tag ,i)">edit</Button>
									<Button type="error" size="small"
									@click="showDeletingModal(tag , i)"
									:loading="tag.isDeleting"
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
				title="Add tag"
				:mask-closable="false"
				:closable="false"
				:draggable="true"
				>
				  <Input v-model="data.tagName" placeholder="Add tag name"  />

				<div slot="footer">
					<Button type="default" @click="addModal = false"> close</Button>
					<Button type="primary" @click="addTag" :disabled="isAdding" :loading="isAdding"> {{isAdding ? 'Adding ...' : 'Add tag'}}</Button>
				</div>
			</Modal>

<!-- tag editing modal -->
			<Modal
				v-model="editModal"
				title="Edit tag"
				:mask-closable="false"
				:closable="false"
				:draggable="true"
				>
				  <Input v-model="editData.tagName" placeholder="Edit tag name"  />

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
				tagName : ''
			},
			addModal : false,
			editModal: false,
			isAdding : false,
			tags: [],
			editData: {
				tagName : ''
			},
			editIndex : 0,
			showDeleteModal: false ,
			deleteItem: {},
			deleteIndex: 0,
			isDeleting : false
		}
	},
	methods : {
		async addTag(){
			this.addModal = false
			// if(this.data.tagName.trim()== '') return this.e();
			const res = await this.$callApi('post' , 'http://blog-laravue.host/app/create_tag' , this.data)
			
			if(res.status === 201) {
				this.s('tag has been added successfully')
				this.tags.unshift(res.data);
				this.addModal = false
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
		async editTag(){
			 if(this.editData.tagName.trim()== '') return this.e("Tag name is required ");
			const res = await this.$callApi('post' , 'http://blog-laravue.host/app/edit_tag' , this.editData)
			
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
			const res = await this.$callApi('post' , 'http://blog-laravue.host/app/delete_tag' ,this.deleteItem);

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

		showEditModal(tag ,i) {
			let obj = {
				id : tag.id,
				tagName : tag.tagName
			}
			this.editTag = i
			this.editModal = true;
			this.editData= obj;
		},
		async getTag() {
			const res = await this.$callApi('get' , 'http://blog-laravue.host/app/get_tags' );
			if(res.status == 200) {
				this.tags = res.data;
			}
			else {
				this.e("can't access to data")
			}
		}
		
	}
	,
	created() {
			this.getTag();
		}
	
}
</script>