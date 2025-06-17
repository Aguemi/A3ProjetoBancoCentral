
package com.example.loan.service;

import com.example.loan.model.Guarantor;
import com.example.loan.repository.GuarantorRepository;
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.Optional;

@Service
public class GuarantorService {
    private final GuarantorRepository repository;

    public GuarantorService(GuarantorRepository repository) {
        this.repository = repository;
    }

    public List<Guarantor> findAll() {
        return repository.findAll();
    }

    public Optional<Guarantor> findById(Long id) {
        return repository.findById(id);
    }

    public Guarantor save(Guarantor obj) {
        return repository.save(obj);
    }

    public void delete(Long id) {
        repository.deleteById(id);
    }
}
