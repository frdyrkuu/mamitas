<div class="grid grid-cols-2 gap-4">
    <div>
        <label class="text-sm text-gray-600">Name</label>
        <p class="font-medium">{{ $supplier->name }}</p>
    </div>
    <div>
        <label class="text-sm text-gray-600">Contact Person</label>
        <p class="font-medium">{{ $supplier->contact_person }}</p>
    </div>
    <div>
        <label class="text-sm text-gray-600">Contact Number</label>
        <p class="font-medium">{{ $supplier->contact_number }}</p>
    </div>
    <div>
        <label class="text-sm text-gray-600">Email</label>
        <p class="font-medium">{{ $supplier->email }}</p>
    </div>
    <div class="col-span-2">
        <label class="text-sm text-gray-600">Address</label>
        <p class="font-medium">{{ $supplier->address }}</p>
    </div>
</div> 