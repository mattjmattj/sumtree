<?php

namespace Sumtree;

class Sumtree
{
    private int $size;
    private int $treeSize;

    /**
     * binary tree containing values
     * for a size of N, the tree will be of size 2N-1 :
     *  { parent nodes : N-1 }{ leaves : N }
     */
    private \SplFixedArray $tree;

    /** the actual data stored in the tree */
    private \SplFixedArray $data;

    /**
     * the insertion point, from left to right, in $data
     * the insertion point in the tree will be calculated on the fly
     */
    private int $pointer;

    public function __construct(int $size)
    {
        $this->pointer = 0;

        $this->size = $size;
        $this->treeSize = 2 * $size - 1;

        $this->tree = new \SplFixedArray($this->treeSize);
        for ($i=0; $i<$this->treeSize; ++$i) {
            $this->tree[$i] = 0;
        }

        $this->data = new \SplFixedArray($size);
        for ($i=0; $i<$size; ++$i) {
            $this->data[$i] = 0;
        }
    }

    public function add(/*mixed*/ $element, float $value): void
    {
        // store the actual data
        $this->data[$this->pointer] = $element;

        // update the values in the tree :
        // we set the leaf value and propagate the difference
        $tree_pointer = $this->pointer + $this->size -1;
        $diff = $value - $this->tree[$tree_pointer];

        $this->tree[$tree_pointer] = $value;

        while ($tree_pointer != 0) {
            $tree_pointer = intdiv($tree_pointer - 1, 2);
            $this->tree[$tree_pointer] += $diff;
        }

        // when we reach capacity, we will go back to the beginning
        $this->pointer = ($this->pointer+1) % $this->size;
    }

    public function getElement(float $value)/*: mixed*/
    {
        // we start from the root
        $parent = 0;

        while (true) {
            // calculate the indexes of our children
            $left = 2 * $parent + 1;
            $right = $left + 1;

            // out of tree : the search is over
            // and the node is $parent
            if ($left >= $this->treeSize) {
                return $this->data[$parent - $this->size + 1];
            }

            // search
            if ($value <= $this->tree[$left]) {
                $parent = $left;
            } else {
                $value -= $this->tree[$left];
                $parent = $right;
            }
        }
    }

    public function sum(): float
    {
        // the sum is simply the value of the root
        return $this->tree[0];
    }

    public function max(): float
    {
        $max = PHP_FLOAT_MIN;
        foreach ($this->tree as $k => $value) {
            if ($k<$this->size -1) {
                continue;
            }
            if ($value > $max) {
                $max = $value;
            }
        }
        return $max;
    }
}
