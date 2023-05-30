<template>
	<div class="banner error-message" v-if="errorArray && errorArray.length > 0">
		<div v-for="error in errorArray">
			<span class="head">
				Error
			</span>
			<span class="error">
				{{ error }}
			</span>
		</div>
	</div>
</template>

<script>
export default {
	props: {
		errors: Array | null,
		error: String,
	},

	computed: {
		errorArray: {
			get() {
				const props = this;
				let errorArray = [];

				if ( props.error )
					errorArray.push( props.error );

				if ( props.errors )
				{
					for ( let i = 0; i < props.errors.length; i++ )
						errorArray.push( props.errors[i] );
				}

				return errorArray;
			}
		}
	}
}
</script>
