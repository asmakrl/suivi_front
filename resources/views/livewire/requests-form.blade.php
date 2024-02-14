<style>
    body {
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }

    .container {
        max-width: 500px;
        margin: 20px auto;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
        border-radius: 8px;
        background-color: #fff;
    }

    h2 {
        text-align: center;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        margin-bottom: 8px;
    }

    input[type="text"],
    input[type="date"],
    textarea,
    select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
    }

    button {
        background-color: #3498db;
        color: #fff;
        padding: 12px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }

    button:hover {
        background-color: #2980b9;
    }

</style>

<div class="container">
    <form wire:submit.prevent="store">

        <h2>Make a Request</h2>

        <div class="form-group">
            <label for="title">Title:</label>
            <input wire:model="title" type="text" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea wire:model="description" id="description" name="description" rows="4" required></textarea>
        </div>
        <div class="form-group">
            <label for="received_at">Received At (Date):</label>
            <input wire:model="date" type="date" id="received_at" name="received_at" required>
        </div>
        <div class="form-group">
            <label for="sender">Sender:</label>
            <input wire:model="sender" type="text" id="sender" name="sender" required>
        </div>
        <div class="form-group">
            <label for="state">State:</label>
            <input wire:model="state" id="state" name="state" required>
        </div>
        <div class="px-4 py-3 flex items-center justify-end">
            <button class="px-3 py-1 bg-blue-500 text-white rounded">submit</button>
        </div>
    </form>

</div>
