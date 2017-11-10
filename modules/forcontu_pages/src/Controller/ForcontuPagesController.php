<?php
/*
* @file
*/

namespace Drupal\forcontu_pages\Controller;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Drupal\user\UserInterface;

class ForcontuPagesController extends ControllerBase{

  public function simple(){
    return array(
      '#markup' => '<p>'. $this->t('This is a simple page (with no arguments)') . '</p>',
    );
  }

  public function calculator($num1, $num2){

    if(!is_numeric($num1) || !is_numeric($num2)){

      throw new BadRequestHttpException(t('No numeric arguments specified.'));

    }
    $list[]= $this->t("@num1 + @num2 = @sum",
                    array('@num1' => $num1,
                          '@num2' => $num2,
                          '@sum' => $num1 + $num2));
    $list[]= $this->t("@num1 - @num2 = @difference",
                    array('@num1' => $num1,
                          '@num2' => $num2,
                          '@difference' => $num1 - $num2));
    $list[]= $this->t("@num1 x @num2 = @product",
                    array('@num1' => $num1,
                          '@num2' => $num2,
                          '@product' => $num1 * $num2));
    if($num2 != 0){

      $list[]= $this->t("@num1 / @num2 = @division",
                      array('@num1' => $num1,
                            '@num2' => $num2,
                            '@division' => $num1 / $num2));

    }else{

      $list[] = $this->t("@num1 / @num2 = undefined (division by Zero)", array('@num1' => $num1, '@num2' => $num2));

    }
    $output['forcontu_pages_calculator'] = array(

      '#theme' => 'item_list',
      '#items' => $list,
      '#title' => $this->t('Operations:'),

    );

    return $output;

  }

  public function user(UserInterface $user) {
    $list[] = $this->t("Username: @username",
              array('@username' => $user->getAccountName()));
    $list[] = $this->t("Email: @email",
              array('@email' => $user->getEmail()));
    $list[] = $this->t("Roles: @roles",
              array('@roles' => implode(', ', $user->getRoles())));
    $list[] = $this->t("Last accessed time: @lastaccess",
              array('@lastaccess' => \Drupal::service('date.formatter')->format($user->getLastAccessedTime(), 'short')));
    $output['forcontu_pages_user'] = array(
      '#theme' => 'item_list',
      '#items' => $list,
      '#title' => $this->t('User data:'),
    );
    return $output;
  }
}
