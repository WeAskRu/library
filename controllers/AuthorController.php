<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\Author;
use app\models\BookAuthor;
use app\services\AuthorService;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AuthorController implements the CRUD actions for Author model.
 */
class AuthorController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'only' => ['create', 'update', 'delete'],
                    'rules' => [
                        [
                            'actions' => ['create', 'update', 'delete'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Author models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Author::find(),
            'pagination' => [
                'pageSize' => 5
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        return $this->render('index', [
            'guest' => Yii::$app->user->isGuest,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView(int $id)
    {
        return $this->render('view', [
            'guest' => Yii::$app->user->isGuest,
            'author' => $this->findModel($id),
        ]);
    }

    public function actionTop()
    {
        $bookAuthors = BookAuthor::find()
            ->select('author_id, COUNT(book_id) as countBooks')
            ->groupBy('author_id')
            ->orderBy('countBooks DESC')
            ->limit(10)
            ->all();

        return $this->render('top', [
            'bookAuthors' => $bookAuthors,
        ]);
    }

    public function actionCreate()
    {
        $author = new Author();

        if ($this->request->isPost) {
            if ($author->load($this->request->post()) && $author->save()) {
                return $this->redirect(['view', 'id' => $author->id]);
            }
        } else {
            $author->loadDefaultValues();
        }

        return $this->render('create', [
            'author' => $author,
        ]);
    }

    public function actionUpdate(int $id)
    {
        $author = $this->findModel($id);

        if ($this->request->isPost && $author->load($this->request->post()) && $author->save()) {
            return $this->redirect(['view', 'id' => $author->id]);
        }

        return $this->render('update', [
            'author' => $author,
        ]);
    }

    public function actionDelete(int $id)
    {
        AuthorService::delete($id);

        return $this->redirect(['index']);
    }

    protected function findModel(int $id)
    {
        if (($author = Author::findOne(['id' => $id])) !== null) {
            return $author;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
