<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\Book;
use app\services\BookAuthorService;
use app\services\BookService;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * BookController implements the CRUD actions for Book model.
 */
class BookController extends Controller
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

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Book::find(),
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
        $book = $this->findModel($id);
        return $this->render('view', [
            'guest' => Yii::$app->user->isGuest,
            'book' => $book,
            'authors' => BookAuthorService::getBooksAuthorsWithIndex($book->id),
        ]);
    }

    public function actionCreate()
    {
        $book = new Book();

        if ($this->request->isPost) {
            if ($book->load($this->request->post())) {
                if (BookService::save($book)) {
                    return $this->redirect(['view', 'id' => $book->id]);
                }
            }
        } else {
            $book->loadDefaultValues();
        }

        return $this->render('create', [
            'book' => $book,
        ]);
    }

    public function actionUpdate(int $id)
    {
        $book = $this->findModel($id);

        if ($this->request->isPost && $book->load($this->request->post())) {
            if (BookService::save($book)) {
                return $this->redirect(['view', 'id' => $book->id]);
            }
        }

        return $this->render('update', [
            'book' => $book,
        ]);
    }

    public function actionDelete(int $id)
    {
        BookService::delete($id);

        return $this->redirect(['index']);
    }

    protected function findModel(int $id): Book
    {
        if (($model = Book::findOne(['id' => $id])->withAuthors()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
