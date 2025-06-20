
package com.example.loan.service;

import com.example.loan.model.Contract;
import com.example.loan.repository.ContractRepository;
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.Optional;

@Service
public class ContractService {
    private final ContractRepository repository;

    public ContractService(ContractRepository repository) {
        this.repository = repository;
    }

    public List<Contract> findAll() {
        return repository.findAll();
    }

    public Optional<Contract> findById(Long id) {
        return repository.findById(id);
    }

    public Contract save(Contract obj) {
        return repository.save(obj);
    }

    public void delete(Long id) {
        repository.deleteById(id);
    }
}
