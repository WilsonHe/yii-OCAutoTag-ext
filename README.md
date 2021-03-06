OCAutoTags Extension for Yii
=============================

Thank you for using OCAutoTag Extension for Yii.

OCAutoTag is a useful extension to auto generate tags by using Open Calais service. This extension is based on Open Calais Tags PHP class written by Dan Grossman, see http://www.dangrossman.info/open-calais-tags/.

Currently only English and French is supported by Calais.

LICENSE
-------

BSD License


REQUIREMENTS
------------

Calais is free for both personal and commercial use, and you need an Calais API key in order to use this extension. Getting an API key is very easy, just sign up at Calais website http://opencalais.com/, then request a key through their automated system.


INSTALLATION
------------

Extract the release file under protected/extensions folder.


USAGE
-----

See an eample used in Blog Demo:

In config file main.php, add to component:
```
        'components'=>array(
          ......
          'OCAutoTag'=>array(
	          'class'=>'application.extensions.OCAutoTag.EOCAutoTagComponent',
	          'oc_api_key'=>'calais_api_key', // required, add your Calais API key here
	          'tag_delimiter'=>',', // Optional, set tag delimiter here
          ),
          ......
        )
```
Modify actionCreate() action in PostController.php file:
```
      	public function actionCreate()
      	{
      		$post=new Post;
      		if(isset($_POST['Post']))
      		{
      		  $oc = Yii::app()->OCAutoTag; // Get an OCAutoTag instance
      		  $auto_tag = $oc->getTags($_POST['Post']['content']); // Get tag in string by sending in post content
      		  if(!empty($auto_tag))
      		    $_POST['Post']['tags'] = !empty($_POST['Post']['tags'])?$_POST['Post']['tags'].$oc->getTagDelimiter().$auto_tag:$auto_tag; // Append auto generated tags to user input tags if $auto_tag is not empty

      			$post->attributes=$_POST['Post'];
      			if(isset($_POST['previewPost'])){
      				$post->validate();
      			}
      			else if(isset($_POST['submitPost']) && $post->save())
      				$this->redirect(array('show','id'=>$post->id));
      		}
      		$this->render('create',array('post'=>$post));
      	}
```