<div style="background:#fff; margin:20px 0;" class="checklist-parent" data-id="[data.checklist_id]">
	<h1 class="cpn-header" data-name="title">
		[data.checklist_name]
	</h1>
	<input type="hidden" name="id" value="[data.checklist_id]" />
	<div style="padding:5px">
		<div class="checklist-item">
			<span class="checklist-delete" data-item="[list.$]"></span>
			<input name="check[[list.$]]" type="checkbox" id="checkitem-[data.checklist_id]-[list.$]" [list.check;att=checked;atttrue=1] />
			<label name="label[[list.$]]" for="checkitem-[data.checklist_id]-[list.$]"></label>
			<span class="checklist-text" data-name="text[[list.$]]">[list.text;block=div]</span>
		</div>
	</div>

	<span class="cpn-button checklist-remove">Remove List</span>
	<div class="checklist-add">
		<button class="cpn-button">Add Item</button>
	</div>
</div>
