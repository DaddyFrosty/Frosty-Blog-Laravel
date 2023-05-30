<template>
	<div class="modal fade" tabindex="-1" id="confirmModal" role="dialog">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<div class="modal-title">
						<h3>{{ title }}</h3>
					</div>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" v-show="!waiting">
					<h4>{{ body }}</h4>
				</div>
				<div class="text-center modal-loading" v-show="waiting" id="spinner">
					<br>
					<div class="spinner-border text-primary" style="width: 8rem; height: 8rem;" role="status"></div>
					<h2>Loading...</h2>
				</div>
				<div class="modal-footer">
					<div class="row">
						<div class="col">
							<div class="left">
								<button type="button" v-bind="{ disabled: waiting }" class="button bg-primary left" @click="onClose">
									{{ options[0] }}
								</button>
							</div>
						</div>
						<div class="col">
							<div class="right">
								<button type="button" v-bind="{ disabled: waiting }" class="button bg-danger" @click="onSubmitInternal">
									{{ options[1] }}
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	props: {
		title : String,
		body: String,
		options: Array,
		autoclose: Boolean | undefined,
		// onSubmit: Function | null,
	},
	name: "confirmModal",
	methods: {
		close() {
			this.$el.modal("hide");
			this.$emit('close');
			this.show = false;
		},
		open() {
			this.$el.modal("show");
			this.$emit('show');
		},
		onClose() {
			this.$emit('cancel');
			this.close();
		},
		onSubmitInternal() {
			this.$emit('submit');

			if ( this.autoclose == undefined || this.autoclose === true )
				this.close();
		},
		wait() {
			this.waiting = true;
		}
	},
	data() {
		return {
			show: true,
			waiting: false
		};
	}
};
</script>
