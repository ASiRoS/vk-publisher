<?php 

class Schedule
{
	/* Selecting */
	
	public function getPost ($id) {
		$db = DB::getInstance();
		$db->setConditions(['where' => function () use ($id) {
			return Text::convertArrayFieldsToText([
				'id' => $id,
			]);
		}]);
		$post = $db->select('posts', ['text', 'imagesLinks']);
		return $post;
	}

	public function getPosts () {
		$db = DB::getInstance();
		$requests = $db->select('requests', ['postID', 'VKGroupID'] , true);
		$result = [];
		foreach ($requests as $request) {
			$db->setConditions(['where' => function () use ($request) {
				return Text::convertArrayFieldsToText(['id' => $request['postID']]);
			}]);
			$result[] = array_merge($db->select('posts', ['text', 'imagesLinks']), ['VKGroupID' => $request['VKGroupID']]
			);
		}
		return $result;
	}
	
	public function getLastRequest () {
		$db = DB::getInstance();
		$request = $db->select('requests', ['id', 'postID', 'VKGroupID']);
		return $request;
	}

	/* Adding */

	public function addPost ($text, $imagesLinks) {
		$db = DB::getInstance();
		return $db->insert('posts', ['text' => $text, 'imagesLinks' => implode(', ', $imagesLinks)]);
	}

	public function addRequest ($postID, $VKGroupID) {
		$db = DB::getInstance();
		return $db->insert('requests', ['postID' => $postID, 'VKGroupID' => $VKGroupID]);
	}	

	/* Deleting */

	public function deleteRequest ($id)
	{
		$db = DB::getInstance();
		$db->setConditions(['where' => function () use($id) {
			return "id = $id";
		}]);
		return $db->delete('requests');
	} 

	/* Request */

	public function request ($method, callable $action) {
		if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET[$method])) {
			$action();
		}
	}
}