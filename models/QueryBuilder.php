<?php

namespace Model;

class QueryBuilder {
   private $fields = [];
   private $conditions = [];
   private $from = [];
   private $joins = [];
   private $limit = null;
   private $groupBy = [];
   private $orderBy = [];

   public function __toString(): string
   {
      $where = $this->conditions === [] ? '' : ' WHERE ' . implode(' AND ', $this->conditions);
      $join = $this->joins === [] ? '' : ' ' . implode(' ', $this->joins);
      $groupBy = $this->groupBy === [] ? '' : ' GROUP BY ' . implode(', ', $this->groupBy);   
      $orderBy = $this->orderBy === [] ? '' : ' ORDER BY ' . implode(', ', $this->orderBy);
      $limit = $this->limit === null ? '' : ' LIMIT ' . $this->limit;
      return 'SELECT ' . implode(', ', $this->fields)
         . ' FROM ' . implode(', ', $this->from) 
         . $join
         . $where
         . $groupBy
         . $orderBy
         . $limit;
   }
   
   public function select(string ...$select): self
   {
      $this->fields = $select;
      return $this;
   }

   public function where(string ...$where): self
   {
      foreach ($where as $arg) {
         $this->conditions[] = $arg;
      }
      return $this;
   }

   public function from(string $table, ?string $alias = null): self
   {
      if ($alias === null) {
         $this->from[] = $table;
      } else {
         $this->from[] = "${table} AS ${alias}";
      }
      return $this;
   }

   public function join(string $join = "INNER JOIN", string $table, string $on, ?string $alias = null): self
   {
      if ($alias === null) {
         $this->joins[] =  "${join} ${table} ON ${on}";
      } else {
         $this->joins[] = "${join} ${table} AS ${alias} ON ${on}";
      }
      return $this;
   }

   public function groupBy(string ...$groupBy): self
   {
      foreach ($groupBy as $arg) {
         $this->groupBy[] = $arg;
      }
      return $this;
   }

   public function orderBy($orderBy, string $order = 'ASC'): self
   {
      $this->orderBy[] = "${orderBy} ${order}";
      return $this;
   }

   public function limit(int $limit): self
   {
      $this->limit = $limit;
      return $this;
   }
}