
<form method="POST" action="add_dish.php">
<label for="dish-name">菜品名稱：</label>
<input type="text" name="dish-name" required><br>

<label for="description">描述：</label>
<textarea name="description"></textarea><br>

<label for="price">價格：</label>
<input type="number" step="0.01" name="price" required><br>

<input type="submit" value="新增菜品">
</form>
