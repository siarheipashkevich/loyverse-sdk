<?php

namespace Esupl\Loyverse\Actions;

use Esupl\Loyverse\Resources\Employee;

/**
 * Trait ManagesEmployees
 *
 * @package Esupl\Loyverse\Actions
 */
trait ManagesEmployees
{
    /**
     * Get the collection of employees.
     *
     * @return Employee[]
     */
    public function employees(): array
    {
        return $this->transformCollection($this->get('employees')['employees'], Employee::class);
    }

    /**
     * Get a single employee.
     *
     * @param string $employeeId
     * @return Employee
     */
    public function employee(string $employeeId): Employee
    {
        return new Employee($this->get("employees/$employeeId"));
    }
}
