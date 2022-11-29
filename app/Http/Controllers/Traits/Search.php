<?php

namespace App\Http\Controllers\Traits;

use App\Helper;

trait Search {

  /**
   * Replaces spaces with full text search wildcards
   *
   * @param string $term
   * @return string
   */
  protected function fullTextWildcards($term)
  {
      // removing spaces
      $query = Helper::spaces(trim($term));
      // removing symbols used by MySQL
      $reservedSymbols = ['-', '+', '<', '>', '@', '(', ')', '~','*'];
      $term = str_replace($reservedSymbols, '', $query);

      $words = explode(' ', $term);

      foreach($words as $key => $word) {
          /*
           * applying + operator (required word) only big words
           * because smaller ones are not indexed by mysql
           */
        if(strlen($word) >= 3) {
              $words[$key] = '+' . $word . '*';
          }
      }

      $searchTerm = implode( ' ', $words);

      return $searchTerm;
  }

  /**
   * Scope a query that matches a full text search of term.
   *
   * @param \Illuminate\Database\Eloquent\Builder $query
   * @param string $term
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeSearch($query, $term)
  {
    $columns = implode(',',$this->searchable);

    $searchableTerm = $this->fullTextWildcards($term);

    return $query->selectRaw("*, MATCH ({$columns}) AGAINST (? IN BOOLEAN MODE) AS relevance", [$searchableTerm])
        ->whereRaw("MATCH ({$columns}) AGAINST (? IN BOOLEAN MODE)", $searchableTerm)
        ->groupBy('id')
        ->orderByDesc('relevance');
      }

      /**
       * Scope a query that matches a like search of term.
       *
       * @param \Illuminate\Database\Eloquent\Builder $query
       * @param string $term
       * @return \Illuminate\Database\Eloquent\Builder
       */
      public function scopeSearchLike($query, $term)
      {
        $queryMatch = Helper::spaces(trim($term));
    		$replace = ['@','+','-','<','>','(',')','*','~'];
    		$queryMatch = str_replace( $replace, '', $queryMatch);

    		return $query->whereStatus('active')
        ->where('tags', 'LIKE', '%' . $queryMatch . '%')
        ->orWhere('title', 'LIKE', '%' . $queryMatch . '%')
        ->whereStatus('active')
        ->groupBy('id')
        ->orderBy('id', 'desc');

      }
}
