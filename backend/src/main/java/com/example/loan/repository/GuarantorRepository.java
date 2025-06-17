
package com.example.loan.repository;

import com.example.loan.model.Guarantor;
import org.springframework.data.jpa.repository.JpaRepository;

public interface GuarantorRepository extends JpaRepository<Guarantor, Long> {
}
