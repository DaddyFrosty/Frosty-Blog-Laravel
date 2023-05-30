<template>
	<div class="banner success-message" v-if="messagesArray">
		<div v-for="message in messagesArray">
			<span class="head">
				Success!
			</span>
			<span class="success">
				{{ message }}
			</span>
		</div>
	</div>
</template>

<script>
export default {
	props: {
		messages: Array | null,
	},
	computed: {
		messagesArray: {
			get() {
				if ( this.messages == null || this.messages.length == 0 )
					return null;

				let filteredArray = [];
				for ( let i = 0; i < this.messages.length; i++ )
				{
					if ( this.messages[i] == null )
						continue;
					filteredArray.push( this.messages[i] );
				}

				return filteredArray.length > 0 ? filteredArray : null;
			}
		}
	}
}
</script>
